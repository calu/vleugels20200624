<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>factuur</title>
      
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
      integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T"
      crossorigin="anonymous">
    <link href="{{ asset('styles/main_styles.css') }}" rel="stylesheet" text="text/css">
        
    <style>
    .logo {
        position : absolute;
        top : 1%;
        right : 70%;
        bottom : 90%;
        left : 1%;
//        background : gold;
//        border : 1px solid blue;
    }   
    
    .adres{
        position : absolute;
        top : 1%;
        right : 0%;
        bottom : 80%;
        left : 70%;
    }
    
    .bestemmeling {
        position : absolute;
        top : 11%;
        right : 70%;
        bottom : 80%;
        left : 1%;
//        background : gold;
//        border : 1px solid blue;
    }       
    
    
    .tabel11{
        position : absolute;
        top : 28%;
        left : 10%;
        right : 70%;
        background-color : blue;
        color : white;
        text-align : center;
        border : 1px solid blue;
    }
    .tabel21{
        position : absolute;
        top : 30%;
        left : 10%;
        right : 70%;
        text-align : center;
        border : 1px solid blue;
    }
    
    .tabel12{
        position : absolute;
        top : 28%;
        left : 30%;
        right : 50%;
        background-color : blue;
        color : white;
        text-align : center;
        border : 1px solid blue;
        
    }
    .tabel22{
        position : absolute;
        top : 30%;
        left : 30%;
        right : 50%;
        text-align : center;
        border : 1px solid blue;
    }    
    
    .tabel13{
        position : absolute;
        top : 28%;
        left : 50%;
        right : 30%;
        background-color : blue;
        text-align : center;
        color : white;
        border : 1px solid blue;
    }    
    .tabel23{
        position : absolute;
        top : 30%;
        left : 50%;
        right : 30%;
        text-align : center;
        border : 1px solid blue;
    }  
    
    .tabel14{
        position : absolute;
        top : 28%;
        left : 70%;
        right : 10%;
        background-color : blue;
        text-align : center;
        color : white;
        border : 1px solid blue;
    }    
    .tabel24{
        position : absolute;
        top : 30%;
        left : 70%;
        right : 10%;
        text-align : center;
        border : 1px solid blue;
    }      
    
    .tabelF11{
        position : absolute;
        top : 35%;
        left : 0%;
        right : 40%;
        background-color : blue;
        color : white;
        text-align : left;
        text-indent : 5px;
        border : 1px solid blue;
    }
    .tabelF21{
        position : absolute;
        top : 38%;
        height : 5%;
        left : 0%;
        right : 40%;
        text-align : left;
        text-indent : 5px;
        word-wrap : normal;
        border : 1px solid blue;        
    }
    
     .tabelF12{
        position : absolute;
        top : 35%;
        left : 60%;
        right : 25%;
        background-color : blue;
        color : white;
        text-align : left;
        text-indent : 5px;
        border : 1px solid blue;
    }
    .tabelF22{
        position : absolute;
        top : 38%;
        height : 5%;
        left : 60%;
        right : 25%;
        text-align : left;
        text-indent : 5px;
        word-wrap : normal;
        border : 1px solid blue;        
    }   
    
     .tabelF13{
        position : absolute;
        top : 35%;
        left : 75%;
        right : 15%;
        background-color : blue;
        color : white;
        text-align : left;
        text-indent : 5px;
        border : 1px solid blue;
    }
    .tabelF23{
        position : absolute;
        top : 38%;
        height : 5%;
        left : 75%;
        right : 15%;
        text-align : left;
        text-indent : 5px;
        word-wrap : normal;
        border : 1px solid blue;        
    }      
    
     .tabelF14{
        position : absolute;
        top : 35%;
        left : 85%;
        right : 0%;
        background-color : blue;
        color : white;
        text-align : left;
        text-indent : 5px;
        border : 1px solid blue;
    }
    .tabelF24{
        position : absolute;
        top : 38%;
        height : 5%;
        left : 85%;
        right : 0%;
        text-align : left;
        text-indent : 5px;
        word-wrap : normal;
        border : 1px solid blue;        
    }     
    
    
     .tabelT11{
        position : absolute;
        top : 44%;
        left : 65%;
        right : 0%;

        text-align : left;
        text-indent : 5px;
        border : 1px solid blue;
    }
    .tabelT12{
        position : absolute;
        top : 44%;
        left : 85%;
        right : 0%;
        text-align : left;
        text-indent : 5px;
        word-wrap : normal;
        border : 1px solid blue;        
    }    
    
    .footer{
        position : absolute;
        top : 90%;
        left : 5%;
        right : 5%;
        text-align : left;
        word-wrap : normal;
    } 
    
.test {
  position: absolute;
  top: 60%;
  right: 40%;
  left: 15%;
  background: red;
  border: 1px solid red;
}        
    </style>       

</head>

<body>
    
    <div class="container">
            <span class="logo">
                <img src="img/logovleugels.png" />
            </span>
            <span class="adres">
                De Vleugels vzw<br />
                Stokstraat 1<br />
                8650 Klerken<br />
                tel : 051 50 12 12<br />
                e-mail : info@devleugels.be<br /><br />
                Bank : ???<br />
                IBAN : ???<br />
                BIC : ???<br />
            </span>
            
            <span class="bestemmeling">
                Aan : <br />
                {{ $naam }}<br />
                {{ $straat}},{{ $huisnummer}} {{ $bus }}<br />
                {{ $postcode}}   {{ $gemeente }}<br />
                <br />
                <span style="font:bold">Factuur</span>
            </span>
            
            <span class="tabel11">factuurnr</span>
            <span class="tabel21">{{ $factuurnummer }}</span>
            <span class="tabel12">factuurdatum</span>
            <span class="tabel22">{{ $factuurdatum }}</span>
            <span class="tabel13">vervaldag</span>
            <span class="tabel23">{{ $vervaldatum }}</span>
            <span class="tabel14">Onze Ref</span>
            <span class="tabel24">{{ $onzeref }}</span>
                
            <span class="tabelF11">Omschrijving</span>
            <span class="tabelF21">{{ $omschrijving }}</span>
            <span class="tabelF12">Bedrag</span>
            <span class="tabelF22">{{ $bedrag1 }}</span>
            <span class="tabelF13">BTW</span>
            <span class="tabelF23">{{ $btw }}</span>
            <span class="tabelF14">totaal</span>
            <span class="tabelF24">{{ $bedrag }}</span>
                
            <span class="tabelT11">Te betalen</span>
            <span class="tabelT12">{{ $bedrag }}</span>
            
            <span class="footer">We verzoeken u vriendelijk het verschuldigde bedrag
               binnen de 30 dagen over te maken met vermelding van het factuurnummer</span>
    </div>
</body>
</html>