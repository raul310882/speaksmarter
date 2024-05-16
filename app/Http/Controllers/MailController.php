<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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

        //$fecha="01-ENE-2024";
        $con_acentos = array('Á', 'É', 'Í', 'Ó', 'Ú', 'á', 'é', 'í', 'ó', 'ú');
		$sin_acentos = array('A', 'E', 'I', 'O', 'U', 'a', 'e', 'i', 'o', 'u');
       
        $inbox = imap_open($mailbox, $user, $password) or die("error en conexion".imap_last_error());

        $emails = imap_search($inbox, 'SUBJECT "Operador" SINCE "1 May 2024"');

        if ($emails){
            foreach ($emails as $email_number){
                $structure = imap_fetchstructure($inbox, $email_number);

                $attachments = array();
                $correo = array();
                if(isset($structure->parts) && count($structure->parts)) {

	                for($i = 0; $i < count($structure->parts); $i++) {

		                $attachments[$i] = array (
                        'is_attachment' => false,
                        'filename' => '',
                        'name' => '',
                        'attachment' => ''
		                );
		
		                if($structure->parts[$i]->ifdparameters) {
                            foreach($structure->parts[$i]->dparameters as $object) {
                                if(strtolower($object->attribute) == 'filename') {
                                    $attachments[$i]['is_attachment'] = true;
                                    $attachments[$i]['filename'] = $object->value;
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
                                $attachments[$i]['attachment'] = base64_decode($attachments[$i]['attachment']);
                            }
                            elseif($structure->parts[$i]->encoding == 4) { // 4 = QUOTED-PRINTABLE
                                $attachments[$i]['attachment'] = quoted_printable_decode($attachments[$i]['attachment']);
                            }
                        }
	                }
                }

                

                for ($i = 0; $i < count($attachments); $i++) {
                    if (!$attachments[$i]['is_attachment']) {
                        unset ($attachments[$i]);
                    }
                }

                $correo[] = imap_fetch_overview($inbox, $email_number);
                $correo[] = str_replace($con_acentos, $sin_acentos, trim(imap_fetchbody($inbox, $email_number, 1.1),"\r\n"));
                $correo[] = $attachments;
                $correos[] = $correo;

            }


        dd($correos);
        
        


        return inertia('Mails/Index');
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
