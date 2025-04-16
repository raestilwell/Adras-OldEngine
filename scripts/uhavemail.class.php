<?php
  /*****************************************************************************************************************************
    UHaveMail class : this class encapsulates the PHP mail() function.
    implements cc, Bcc, Attachments etc

    Version 1.3 - Fixed a bug with the Bcc method

    Example -

      include "uhavemail.class.php";

      $mail = new UHaveMail;							 							// create the mail object
      $mail->From("uhavemail@sender.com");											// set the From Address
      $mail->To("someone@anywhere.com");											// set the To Address
      $mail->Subject("This is the subject");										// set the Subject
      $mail->Body("This is a test message using the php UHaveMail class.\n");		// set the body of the message
      $mail->Cc("copy@anywhere.com");												// set the CC recipients
      $mail->Bcc("blindcopy@anywhere.com");											// set the BCC recipients
      $mail->Attach("/path/to/file.gif", "image/gif");								// attach a file (in this case a GIF image)
      $mail->Send();																// send the mail
      $mail->Get();																	// Get details of the mail

    Last Modified - 20/07/2005

    Author: Ian M

  ******************************************************************************************************************************/
  class UHaveMail
  {
    var $uhavemail_sendto = array();																// List of To addresses
    var $uhavemail_cc = array();																	// List of cc addresses
    var $uhavemail_bcc = array();																	// List of bcc addresses
    var $uhavemail_subject = "";																	// The subject of the message
    var $uhavemail_body = "";																		// The body of the message
    var $uhavemail_Textbody = "";																	// The plain text message body.
    var $uhavemail_attach = array();																// List of attachments
    var $uhavemail_headers = array();																// Message headers
    var $charset = "us-ascii";																		// Character set to use
    var $ctencoding = "7bit";																		// Encoding to use
    var $receipt = 0;																				// Receipt required (0 = no, 1 = yes)
    var $checkAddress = "";
//    var $priorities = array( '1 (Highest)', '2 (High)', '3 (Normal)', '4 (Low)', '5 (Lowest)' );	// The different priority levels
    var $version = "v1.3";																			// The version of UHaveMail

    /********************************************************************************************
     Constructor for the Class

     Creates an instance of the class and defaults a
     number of the variables
    ********************************************************************************************/
    function UHaveMail()
    {
      $this->useAddressCheck(true);
      $this->boundary= "--NextSegment" . md5(uniqid(time()));
    }

    /********************************************************************************************
     useAddressCheck() - Switch the email address checking on or off
     @param bool $checkThem : true = check addresses, false = don't check addresses
    ********************************************************************************************/
    function useAddressCheck($checkThem)
    {
      if($checkThem)
      {
        $this->checkAddress = true;
      }
      else
      {
        $this->checkAddress = false;
      }
    }

    /********************************************************************************************
      Subject() - Set the subject of the message
       @param string $subject : The subject line for the message
    ********************************************************************************************/
    function Subject($subject)
    {
      $this->uhavemail_subject = strtr($subject, "\r\n" , "  ");
    }

    /********************************************************************************************
      From() - Set the sender of the message
       @param string $from : The sender of the message
    ********************************************************************************************/
    function From($from)
    {
      if(is_string($from))
      {
        $this->uhavemail_headers['From'] = $from;
      }
      else
      {
        echo "UHaveMail: error, From is not a string";
        exit;
      }

      if($this->checkAddress)
      {
        $this->CheckAdresses($from);
      }
    }

    /********************************************************************************************
      ReplyTo() - Set the ReplyTo address for the message
       @param string $address : The address to use
    ********************************************************************************************/
    function ReplyTo($address)
    {
      if(is_string($address))
      {
        $this->uhavemail_headers["Reply-To"] = $address;
      }
      else
      {
        echo "UHaveMail: error, ReplyTo is not a string";
        exit;
      }

      if($this->checkAddress)
      {
        $this->CheckAdresses($address);
      }
    }

    /********************************************************************************************
     Receipt() - Add a receipt request to the mail ie.  a confirmation is returned to the
     "From" address (or "ReplyTo" if defined) when the receiver opens the message.

     Warning this functionality is not a standard, so not all mail clients will reply
    ********************************************************************************************/
    function Receipt()
    {
      $this->receipt = 1;
    }

    /********************************************************************************************
     To() - Set the mail recipient - accepts either a single address or an array of addresses
     @param string $to : the primary recipient details
    ********************************************************************************************/
    function To($to)
    {
      if(is_array($to))
      {
        $this->uhavemail_sendto= $to;
      }
      else
      {
        $this->uhavemail_sendto[] = $to;
      }

      if($this->checkAddress)
      {
        $this->CheckAdresses($this->uhavemail_sendto);
      }
    }

    /********************************************************************************************
     Cc() - Set the CC headers - accepts either a single address or an array of addresses
     @param string $cc : the carbon copy recipient details
    ********************************************************************************************/
    function Cc($cc)
    {
      if(is_array($cc))
      {
        $this->uhavemail_cc= $cc;
      }
      else
      {
        $this->uhavemail_cc[]= $cc;
      }

      if($this->checkAddress)
      {
        $this->CheckAdresses($this->uhavemail_cc);
      }
    }

    /********************************************************************************************
     Bcc() - Set the BCC headers - accepts either a single address or an array of addresses
     @param string $bcc : the blind carbon copy recipient details
    ********************************************************************************************/
    function Bcc($bcc)
    {
      if(is_array($bcc))
      {
        $this->uhavemail_bcc = $bcc;
      }
      else
      {
        $this->uhavemail_bcc[]= $bcc;
      }

      if($this->checkAddress)
      {
        $this->CheckAdresses($this->uhavemail_bcc);
      }
    }

    /********************************************************************************************
     Body() - Set up the body of the mail and optionally specify the charset to use
     @param string $body: the body of the message
     @param string $charset : the character set (defaults to us-ascii)
    ********************************************************************************************/
    function Body($body, $charset="")
    {
      $this->uhavemail_Textbody = $body;

      if($charset != "")
      {
        $this->charset = strtolower($charset);
        if($this->charset != "us-ascii")
        {
          $this->uhavemail_encoding = "8bit";
        }
      }
    }

//    /* Set the mail priority to an integer between 1 (highest) and 5 ( lowest ) */
//       $priority : Integer representing the required priority
//    /*
//    /* ToDo: Setup this function to add a proper priority header
//    function Priority( $priority )
//    {
//      if(! intval($priority))
//      {
//        echo "UHaveMail: error, Priority is not an integer";
//        exit;
//      }
//      if(! isset($this->priorities[$priority-1]))
//      {
//        echo "UHaveMail: error, Priority is an invalid value";
//        exit;
//      }
//
//      $this->xheaders["X-Priority"] = $this->priorities[$priority-1];
//      return true;
//    }

    /********************************************************************************************
     Attach() - Attach a file to the mail
      @param string $filename : path of the file to attach
      @param string $filetype : MIME-type of the file. default to 'application/x-unknown-content-type'
      @param string $disposition : instruct the Mail client to display the file if possible ("inline") or
      always as a link ("attachment") possible values are "inline", "attachment"

      ToDo: if filetype="", try and lookup the type of file based on the extension - will need to change the default
                validate disposition and default to inline if invalid
    ********************************************************************************************/
    function Attach($filename, $filetype = "application/x-unknown-content-type", $disposition = "inline")
    {
      $this->uhavemail_attach[] = $filename;
      $this->uhavemail_type[] = $filetype;
      $this->uhavemail_dispo[] = $disposition;
    }

    /********************************************************************************************
     BuildMail() - Build the message ready for sending

     This is a private function
    ********************************************************************************************/
    function BuildMail()
    {
    	$result = true;

      // build the headers
      $this->headers = "";

      $this->strTo = implode(", ", $this->uhavemail_sendto);

      if(count($this->uhavemail_cc) > 0)
      {
        $this->uhavemail_headers['CC'] = implode(", ", $this->uhavemail_cc);
      }

      if(count($this->uhavemail_bcc) > 0)
      {
        $this->uhavemail_headers['BCC'] = implode(", ", $this->uhavemail_bcc);
      }

      if($this->receipt)
      {
        if(isset($this->uhavemail_headers["Reply-To"]))
        {
          $this->uhavemail_headers["Disposition-Notification-To"] = $this->uhavemail_headers["Reply-To"];
        }
        else
        {
          $this->uhavemail_headers["Disposition-Notification-To"] = $this->uhavemail_headers['From'];
        }
      }

      if($this->charset != "")
      {
        $this->uhavemail_headers["Mime-Version"] = "1.0";
        $this->uhavemail_headers["Content-Type"] = "text/plain; charset=$this->charset";
        $this->uhavemail_headers["Content-Transfer-Encoding"] = $this->uhavemail_encoding;
      }

      $this->uhavemail_headers["X-Mailer"] = "Php/UHaveMail ".$this->version;

      // include any attached files
      if(count($this->uhavemail_attach) > 0)
      {
        $result = $this->_buildAttachement();
      }
      else
      {
        $this->uhavemail_body = $this->uhavemail_Textbody;
      }

      reset($this->uhavemail_headers);

      while(list($hdr,$value) = each($this->uhavemail_headers))
      {
        $this->headers .= "$hdr: $value\n";
      }

      return $result;
    }

    /********************************************************************************************
     Send() - Format and send the email
    ********************************************************************************************/
    function Send()
    {
      $result = $this->BuildMail();

      if($result)
      {
	      $result = @mail($this->strTo, $this->uhavemail_subject, $this->uhavemail_body, $this->headers);
	  }

      return $result;
    }

    /********************************************************************************************
     Get() - Return the full e-mail (including headers)
     @return string $mail: the full email
    ********************************************************************************************/
    /* Return the full e-mail (including headers)  */
    function Get()
    {
      $this->BuildMail();

      $mail = "To: " . $this->strTo . "\n";
      $mail .= "Subject: " . $this->uhavemail_subject . "\n";
      $mail .= $this->headers . "\n";
      $mail .= $this->uhavemail_body;

      return $mail;
    }

    /********************************************************************************************
     ValidEmailAddress() - check an email address is valid
     @param string $address : email address to check
     @return true if email adress is ok

     ToDo: Currently only checks the format of the email address look at adding
               functionality to verify if the domain is valid and active
    ********************************************************************************************/
    function ValidEmail($address)
    {
      if(ereg(".*<(.+)>", $address, $regs))
      {
        $address = $regs[1];
      }

      if(ereg("^[^@  ]+@([a-zA-Z0-9\-]+\.)+([a-zA-Z0-9\-]{2}|net|com|gov|mil|org|edu|int)\$",$address))
      {
        return true;
      }
      else
      {
        return false;
      }
    }

    /********************************************************************************************
     CheckAddresses() - control checking of email addresses (allows for arrays)
      @param array $addresses : an array of email addresses
    ********************************************************************************************/
    function CheckAdresses($addresses)
    {
      // possible need to check if works with single address
      if (is_array($addresses))
      {
        foreach($addresses as $ad)
        {
          if(!$this->ValidEmail($ad))
          {
            echo "UHaveMail: error, invalid email address $ad";
            exit;
          }
        }
      }
      else
      {
        if(!$this->ValidEmail($addresses))
        {
          echo "UHaveMail: error, invalid email address $ad";
          exit;
        }
      }
    }

    /********************************************************************************************
     _buildAttachment() - encode and attach the files

     This is a private function
    ********************************************************************************************/
    function _buildAttachement()
    {
      $this->uhavemail_headers["Content-Type"] = "multipart/mixed;\n boundary=\"$this->boundary\"";
      $this->uhavemail_body = "This is a multi-part message in MIME format.\n--$this->boundary\n";
      $this->uhavemail_body .= "Content-Type: text/plain; charset=$this->charset\nContent-Transfer-Encoding: $this->ctencoding\n\n" . $this->uhavemail_Textbody ."\n";

      $attachments= array();

      $k=0;

      // for each attached file, do...
      for($i=0; $i < count( $this->uhavemail_attach); $i++)
      {
        $filename = $this->uhavemail_attach[$i];
        $basename = basename($filename);
        $ctype = $this->uhavemail_type[$i];

        // content-type
        $disposition = $this->uhavemail_dispo[$i];

        if(!file_exists($filename))
        {
          echo "UHaveMail: error, file can't be found";
          return false;
        }

        $subhdr= "--$this->boundary\nContent-type: $ctype;\n name=\"$basename\"\nContent-Transfer-Encoding: base64\nContent-Disposition: $disposition;\n  filename=\"$basename\"\n";

        $attachments[$k++] = $subhdr;

        $filedata = implode(file($filename), '');
        $attachments[$k++] = chunk_split(base64_encode($filedata));
      }

      $seperator= chr(13) . chr(10);
      $this->uhavemail_body .= implode($seperator, $attachments);
      $this->uhavemail_body  .= "--$this->boundary--\n";

	    return true;
    }
  }
?>
