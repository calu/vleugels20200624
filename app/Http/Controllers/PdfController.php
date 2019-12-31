<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PDF;
use Illuminate\Mail\Mailable;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendMailable;

class PdfController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
   /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function generatePDF()
    {
         abort_unless(\Auth::check() && \Auth::User()->isAdmin(), 403);
       
        
        $data = ['title' => 'Welcome to HDTuto.com'];
        $pdf = PDF::loadView('boekhouding/sjabloon', $data);
  
//        return $pdf->download('itsolutionstuff.pdf');
//        return $pdf->save('temp/testpdf.pdf')->stream('teststream.pdf');
        $pdf->save('temp/test.pdf')->stream('teststream.pdf');
        // nu hier maile
         Mail::to('johan.calu@gmail.com')->send( new SendMailable());
        // en dan een return naar een goed pagina
        return view('pdf/succes');
    }
    
}
