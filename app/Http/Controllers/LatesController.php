<?php
namespace App\Http\Controllers;
use App\Models\Lates;
use App\Models\Students;
use Barryvdh\DomPDF\PDF as DomPDFPDF;
use Dompdf\Dompdf;
use Maatwebsite\Excel\Facades\Excel;   
use App\Exports\LatesExport;  
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use PDF;
use Illuminate\Support\Facades\Log;

class LatesController extends Controller
{

    public function exportExcel()
    {
        $file_name = 'data_keterlambatan'.'.xlsx';
        return Excel::download(new LatesExport , $file_name);

    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $lates = Lates::with('student')->get();
        $student = Students::all();

        return view('pages.admin.keterlambatan.index', compact('lates', 'student'));
    }

    public function rekap()
    {
        $rekap = Lates::with('student')
            ->select('student_id', DB::raw('count(*) as total'))
            ->groupBy('student_id')
            ->get();

        return view('pages.admin.keterlambatan.rekap', compact('rekap'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $lates = Lates::with('student')->get();
        $student = Students::all();
        return view('pages.admin.keterlambatan.create', compact('lates', 'student'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'student_id' => 'required',
            'information' => 'required',
            'bukti' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'date_time_late' => 'required',
        ]);

        $imageName = time() . '.' . $request->bukti->getClientOriginalExtension();
        $request->bukti->move(public_path('images'), $imageName);

        $late = new Lates([
            'student_id' => $request->get('student_id'),
            'information' => $request->get('information'),
            'bukti' => $imageName,
            'date_time_late' => $request->get('date_time_late'),
        ]);

        $late->save();

        return redirect()->route('late.home')->with('success', 'Berhasil menambah data Keterlambatan');
    }


    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $students = Students::findOrFail($id);
        $lates = Lates::with('student')->where('student_id', $id)->get();
        
        return view('pages.admin.keterlambatan.show', compact('students', 'lates'));
    }
    
    /**
     * Print out the pdf keterlambatan
     */
    public function print(Lates $lates, $id) 
    {
        $data = Students::with('rayon', 'rombel')->findOrFail($id);
        return view('pages.admin.keterlambatan.print', compact('data'));
    } 


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Lates $late, $id)
    {
        $lates = Lates::with('student')->find($id);
        $students = Students::all();

        return view('pages.admin.keterlambatan.edit', compact('lates', 'students'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'student_id' => 'required',
            'information' => 'required',
            'bukti' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'date_time_late' => 'required',
        ]);

        $late = Lates::findOrFail($id);

        $late->student_id = $request->get('student_id');
        $late->information = $request->get('information');
        $late->date_time_late = $request->get('date_time_late');

        if ($request->hasFile('bukti')) {
            $imageName = time() . '.' . $request->bukti->getClientOriginalExtension();
            $request->bukti->move(public_path('images'), $imageName);

            if ($late->bukti) {
                $oldImagePath = public_path('images/' . $late->bukti);
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }
            }

            $late->bukti = $imageName;
        }

        $late->save();

        return redirect()->route('late.home')->with('success', 'Berhasil memperbarui data Keterlambatan');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Lates $late, $id)
    {
        Lates::where('id', $id)->delete();

        return redirect()->route('pages.admin.late.home')->with('success', 'Berhasil Menghapus Data');
    }

    public function downloadPDF($id) {
        try {
            $data = Students::with('rayon', 'rombel')->findOrFail($id)->toArray();
    
            view()->share('data', $data);
    
            $pdf = PDF::loadView('pages.admin.keterlambatan.downloadpdf', $data);
    
            return $pdf->download('Surat Pernyataan.pdf');
            
            return redirect()->route('late.rekap')->with('printed', 'PDF BERHASIL DI CETAK!');
        } finally {
            Log::info('PDF berhasil diunduh untuk mahasiswa dengan ID ' . $id);
        }
    }
    
    
}
