<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use SplSubject;

class MailController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = "transportes.peralta.tabasco@gmail.com";
        $password = "pbeo wgrk lvzl dork";
        $mailbox = "{imap.gmail.com:993/imap/ssl/novalidate-cert}INBOX";

        $inbox = imap_open($mailbox, $user, $password) or die("error en conexion".imap_last_error());

        $emails = imap_search($inbox, 'SUBJECT "Vacante" SINCE "1 may 2024"');

        if ($emails){
            foreach ($emails as $email_number){
                $structure = imap_fetchstructure($inbox, $email_number);

                $correos[$email_number] = array (
                    'subject' => '',
                    'from' => '',
                    'main' => '',
                    'attach' => []
                );
               

                $attachments = array();
                $adjuntos = array();
                if(isset($structure->parts) && count($structure->parts)) {

	                for($i = 0; $i < count($structure->parts); $i++) {

		                $attachments[$i] = array (
                        'is_attachment' => false,
                        'filename' => '',
                        'name' => '',
                        'attachment' => '',
                        'encode' => '',
                        'size' => '',
                        'save' => true
		                );
		
		                if($structure->parts[$i]->ifdparameters) {
                            foreach($structure->parts[$i]->dparameters as $object) {
                                if(strtolower($object->attribute) == 'filename') {
                                    $attachments[$i]['is_attachment'] = true;
                                    $attachments[$i]['filename'] = $object->value;
				                }
                                if($object->attribute == 'SIZE') {
                                    $attachments[$i]['size'] = $object->value;
                                }
			                }
		                }
		
                        if($structure->parts[$i]->ifparameters) {
                            foreach($structure->parts[$i]->parameters as $object) {
                                if(strtolower($object->attribute) == 'name') {
                                    $attachments[$i]['is_attachment'] = true;
                                    $attachments[$i]['name'] = $object->value;
                                }
                            }
                        }
		
                        if($attachments[$i]['is_attachment']) {
                            $attachments[$i]['attachment'] = imap_fetchbody($inbox, $email_number, $i+1);
                            if($structure->parts[$i]->encoding == 3) { // 3 = BASE64
                                /* $data = substr($attachments[$i]['attachment'], strpos($attachments[$i]['attachment'], ',') + 1);
                                $attachments[$i]['attachment'] = $data; */
                                $attachments[$i]['encode'] = 'BASE64';
                            }
                            elseif($structure->parts[$i]->encoding == 4) { // 4 = QUOTED-PRINTABLE
                                $attachments[$i]['attachment'] = quoted_printable_decode($attachments[$i]['attachment']);
                                $attachments[$i]['encode'] = 'QUOTED-PRINTABLE';
                            }
                        } 
	                }
                }
                $i = 0;
                foreach ($attachments as $elemento){
                    if (!$elemento['is_attachment']) {
                        unset ($attachments[$i]);
                    } else {
                        if ($elemento['size'] > 4000000 ) {
                            $adjuntos[$i]['name'] = $elemento['name'].' El elemento excede el tamaño permitido (3 mb)';
                            $adjuntos[$i]['save'] = false;
                        } else {
                            $pdf_decode = base64_decode($elemento['attachment'], true);
                            $pdf_name = 'C:\xampp\htdocs\SPEAKSMARTER\speaksmarter\storage\app\public\pdf_temp/'.$email_number.'cons_'.$i.'_'.$elemento['name'];
                            file_put_contents($pdf_name, $pdf_decode);
                            $adjuntos[$i]['name'] = $email_number.'cons_'.$i.'_'.$elemento['name'];
                            $adjuntos[$i]['save'] = true;
                        }
                    } 
                    $i++;
                }
                $mail = imap_fetch_overview($inbox, $email_number);
                $from = mb_convert_encoding($mail[0]->from, 'UTF-8');
                $subject = $mail[0]->subject;
                $vacante_puesto = explode('-', $subject);  //separa la palabra VACANTE y el PUESTO
                $puesto = explode('Vacante', $vacante_puesto[0]);
                //$puesto = explode ('-', $vacante[1]);    //obtiene el PUESTO
                $nombre = $vacante_puesto[1];

                $correos[$email_number]['from'] = $from;
                $correos[$email_number]['puesto'] = $puesto[1];
                $correos[$email_number]['nombre'] = $nombre;
                $correos[$email_number]['subject'] = $subject;
                $correos[$email_number]['attach'] = $adjuntos;
                $main = imap_fetchbody($inbox, $email_number, 1.1);
    
                $acentos = array("Á", "É", "Í", "Ó", "Ú", "á", "é", "í", "ó", "ú", "ñ");
                $simbolos   = array("=C1", "=C9", "=CD", "=D3", "=FA", "=E1", "=E9", "=ED", "=F3", "=DA", "=F1");

                $main = str_replace($simbolos, $acentos, $main);
                $correos[$email_number]['main'] = $main;
            }

        return inertia('Mails/Index', ['correos' => $correos]);
    }
}

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
