@extends('Model::model_dashboard')
@section('content_sub_model')

<?php
use App\Helpers\Helper as AppHelper;
?>
<div class="right_cont"> <!--all left-->
  <div class="user-header row"> <!--user header-->
    <div class="col-sm-12">
      <div class="dashboard-long-item">
        <div class="dashboard_tabs_wrapper">
          <div class="pull-left">
            <a class="btn btn-dark pull-left {{ ($action == 'commissions') ? 'btn-danger' : 'btn-default'}}" href="{{URL('models/dashboard/account-settings')}}?action=commissions">@lang('messages.commission')</a>
            <a class="btn btn-dark pull-left {{ ($action == 'documents') ? 'btn-danger' : 'btn-default'}}" href="{{URL('models/dashboard/account-settings')}}?action=documents">@lang('messages.documents')</a>
            <a class="btn btn-dark pull-left {{ ($action == 'others') ? 'btn-danger' : 'btn-default'}}" href="{{URL('models/dashboard/account-settings')}}?action=others">Timezone</a>
            <a class="btn btn-dark pull-left {{ ($action == 'contact' || $action == 'edit-contact') ? 'btn-danger' : 'btn-default'}}" href="{{URL('models/dashboard/account-settings')}}?action=contact">@lang('messages.contactSettings')</a>
            <?php /*
            <a class="btn btn-dark pull-left {{ ($action == 'payment' || $action == 'edit-payment') ? 'btn-danger' : 'btn-default'}}" href="{{URL('models/dashboard/account-settings')}}?action=payment">Payment Options</a>
            */ ?>
            <a class="btn btn-dark pull-left {{ ($action == 'payee-info' || $action == 'payee-info') ? 'btn-danger' : 'btn-default'}}" href="{{URL('models/dashboard/account-settings')}}?action=payee-info">@lang('messages.payeeInfo')</a>
            <a class="btn btn-dark pull-left {{ ($action == 'direct-deposity' || $action == 'direct-deposity') ? 'btn-danger' : 'btn-default'}}" href="{{URL('models/dashboard/account-settings')}}?action=direct-deposity">@lang('messages.directDeposit')</a>
            <a class="btn btn-dark pull-left {{ ($action == 'paxum' || $action == 'paxum') ? 'btn-danger' : 'btn-default'}}" href="{{URL('models/dashboard/account-settings')}}?action=paxum">@lang('messages.paxum')</a>
            <a class="btn btn-dark pull-left {{ ($action == 'bitpay' || $action == 'bitpay') ? 'btn-danger' : 'btn-default'}}" href="{{URL('models/dashboard/account-settings')}}?action=bitpay">@lang('messages.bitpay')</a>
            <a class="btn btn-dark pull-left {{ ($action == 'change-password') ? 'btn-danger' : 'btn-default'}}" href="{{URL('models/dashboard/account-settings')}}?action=change-password">@lang('messages.changePassword')</a>
            <a class="btn btn-dark pull-left {{ ($action == 'disable-account') ? 'btn-danger' : 'btn-default'}}" href="{{URL('models/dashboard/account-settings')}}?action=disable-account">@lang('messages.disableAccount')</a>
          </div>
        </div>
      </div>
    </div>
  </div><!--user header end-->
  <div class="clearfix">&nbsp;</div>
  <div class="mod_settings_cont" ng-controller="modelSettingCtrl" ng-cloak> <!--user's info-->
    <?php if ($action && $action == 'commissions') { ?>
      <div class="panel panel-default">
        <table class="table table-bordered">
          <tr>
            <td>@lang('messages.commission')</td>
            <td><span class="h3">{{$commission->referredMember}}%</span>
              <div class="help-block"><span class="text-danger"><i class="fa fa-lightbulb-o"></i>
                  <strong>@lang('messages.hint'): </strong>@lang('messages.youwillgetthiscommission')</span></div>
            </td>
          </tr>
        </table>
      </div> <!--Commission -->
    <?php } ?>
    <?php if ($action && $action == 'others') { ?>
      <div class="panel panel-default">
        <div class="panel-heading"> <h4>@lang('messages.timezone')</h4></div>
        <div class="panel-body">
          <form class="form-horizontal" ng-submit="submitOtherSetting(otherSettingForm)" name="otherSettingForm" method="post" novalidate ng-init="initSettings({{$otherSettings}})">
            <div class="form-group required">
              <label for="s9" class="col-sm-4 control-label input-lg">@lang('messages.timezone')</label>
              <div class="col-sm-8">

                <select class="form-control input-lg" name="timezone" id="otherProfileSettingsForm_timezone" ng-model="settings.timezone" ng-required="true" >
                  <option value="">@lang('messages.pleaseSelectAnOption')</option>
                  @if($timezone)

                  @foreach($timezone as $zone)

                  <option value="{{$zone -> zone_name}}">{{$zone -> zone_name}}</option>

                  @endforeach
                  @endif
                </select>
                <span class="label label-danger" ng-show="otherSettingForm.$submitted && otherSettingForm.timezone.$error.required">@lang('messages.thisFieldIsRequired')</span>
              </div>
            </div>
            <div class="form-group">
              <div class="col-sm-4">
              </div>
              <div class="col-sm-8 text-center">
                <button type="submit" class="btn btn-rose btn-lg btn-block">@lang('messages.updateSettings')</button>
              </div>
            </div>
          </form>
        </div>
      </div><!--Other settings -->
    <?php } ?>
    <?php if ($action && $action == 'documents') { ?>

      <div class="panel panel-default">
        <div class="panel-heading"> <h4>@lang('messages.documents')</h4></div>
        <div class="panel-body">
            @if(!$document)

                

              <form class="form-horizontal" action="/models/dashboard/account-settings/documents" enctype="multipart/form-data" method="post">

                <div class="form-group">
                      <label class="col-sm-12 control-label input-lg" style="text-align: left;"> Foto del DNI: </label>

                  <div class="col-sm-9">
                      <span class="">Para poder transmitir y recibir ingresos hay que añadir la foto del DNI por las 2 caras, para confirmar la mayoria de edad.</span>
                  </div>
              

                </div>
                 




              <div class="form-group required">
               
                <label class="col-sm-3 control-label input-lg">@lang('messages.idImage') </label>
                <div class="col-sm-9">
                    <input name="idImage" id="idImage" type="file" accept="image/*">
                  <div class="help-block">
                    
                    
                    <span class="text-danger">@lang('messages.uploadingAnotherFileWillRemoveTheOldOne')</span>
                  </div>
                  <span class="label label-danger">{{$errors->first('idImage')}}</span>
                </div>
              </div>


              <div class="form-group required">
               
                <label class="col-sm-3 control-label input-lg">@lang('messages.idImage2') </label>
                <div class="col-sm-9">
                    <input name="idImage2" id="idImage2" type="file" accept="image/*">
                  <div class="help-block">

                    <span class="text-danger">@lang('messages.uploadingAnotherFileWillRemoveTheOldOne')</span>
                  </div>
                  <span class="label label-danger">{{$errors->first('idImage2')}}</span>
                </div>
              </div>


              <div class="form-group required">
                <label class="col-sm-3 control-label input-lg">@lang('messages.faceIDImage')</label>
                <div class="col-sm-9">
                    <input name="faceId" id="faceId" type="file" accept="image/*">
                  <div class="help-block">
                    <span class="">@lang('messages.faceidtext')</span>

                    <br>
                    <span class="text-danger">@lang('messages.herfilewillremovetheoldone')</span></div>
                  <span class="label label-danger">{{$errors->first('faceId')}}</span>
                </div>
              </div>


    
              <div class="form-group required col-sm-12">
                <h2 class="  input-lg text-center">Acuerdo independiente de emisor/a</h2>
                <div class="col-sm-11" style="height: 400px;
    overflow: auto;
    margin-left: 50px;
    border: 1px solid;">

<strong>Acuerdo independiente de emisor/a: </strong>

This electronic agreement is a legally binding and enforceable contract (referred to herein as the “Agreement”, “Document”) between you (“Independent Creator”, “Studio”, “you”, “your”, “they”) and Implik-2 Spain (“Website”, “Platform”, “we”, “us”). By providing your electronic signature and all the required information and documents you are actually agreeing to be bound by this Agreement in its entirety and accepting all the provisions herein contained, and you acknowledge that this Agreement is intended to be governed by the Electronic Signatures in Global and National Commerce Act. By entering into this Agreement you understand that you are requesting permission to access the software facilities operated by Implik-2 to stream your live, interactive webcam shows as well as to upload and distribute recorded content (such as videos, images and chat texts) to other users of this Platform. You therefore acknowledge that the Platform will only provide you with the technical functionalities necessary for you to market your own content, and that therefore the Platform will not be liable for any of your actions or inactions or those of other Independent Creators, Users or third parties. As described in more detail in the Terms and Conditions of this Platform, the Platform and its Website (as defined here) constitute an online Platform that provides social media-like services, including a chat with text and image options through which anyone accessing the Platform (whether it be a “Member of the Community” or a “User”) shall create and share online with fellow Community Members audio and video files as well as live streaming which may include, a the Member of the Community’s election, adult content. The Platform allows for the live broadcast of this Content as well as the communication between the Independent Creator and the Members of the Community allowing them to share entertainment and interaction by supplying the required software for the live broadcast of such content. Implik-2 operates the Website Platforme which simply manages the technical, organizational and contractual frameworks required to provide you and let you use the content; in other words, the Platform only works to maintain and develop the technical means that allow you to see the content published by other Users and Independent Creators, and to let you interact with the Independent Creators during their live-streaming interactive sessions.

Este acuerdo electrónico es un contrato legalmente vinculante y ejecutable (denominado en este documento el "Acuerdo", "Documento") entre usted ("Creador independiente", "Studio", "usted", "su", "ellos") y Implik-2 España ("Sitio web", "Plataforma", "nosotros", "nos"). Al proporcionar su firma electrónica y toda la información y documentos requeridos, acepta estar obligado por este Acuerdo en su totalidad y todas las disposiciones aquí contenidas. Al firmar este acuerdo, usted comprende que está accediendo a las instalaciones de software operadas por Implik-2 con el fin de transmitir en vivo sus programas interactivos de cámara web, así como para cargar y distribuir contenido grabado como videos, imágenes y textos de chat entre otros a otros usuarios de esta Plataforma. Por lo tanto, reconoce que la Plataforma solo le proporcionará las funcionalidades técnicas necesarias para poder comercializar su contenido y que esta no será responsable de ninguna de las acciones u omisiones de otros creadores independientes, usuarios o terceros. Como se describe con más detalle en los Términos y condiciones, tanto la Plataforma como su sitio web proporcionan un servicio en línea similar a las redes sociales, incluido un chat con opciones de texto e imagen a través del cual cualquier persona que acceda a la Plataforma, ya sea un "Miembro de la Comunidad" o un "Usuario”, creará y compartirá en línea con otros miembros de la comunidad archivos de audio y vídeo, así como transmisión en vivo que puede incluir, a elección del miembro de la comunidad, contenido para adultos. La Plataforma permite la transmisión en vivo de este contenido, así como la comunicación entre el creador independiente y los miembros de la comunidad, permitiéndoles compartir entretenimiento e interacción.   Implik-2 gestiona la Plataforma de sitios web que administra los marcos técnicos, organizativos y contractuales requeridos para proporcionarle y permitirle usar el contenido; en otras palabras, la Plataforma solo trabaja para mantener y desarrollar los medios técnicos que le permiten ver el contenido publicado por otros usuarios y creadores independientes, e interactuar con estos durante sus sesiones interactivas en vivo.
<ol>
  <li>LEGAL AGE By signing this document you, the Independent Creator, confirm that you have reached the age of majority in your jurisdiction, which will be at least 18 years of age or the legal age in your location (i.e. “Age Majority”), whichever figure is higher, and that you are under no national, regional or local legal provision that might somehow prohibit you from entering this agreement. IF THAT IS NOT THE CASE, PLEASE CLOSE THIS DOCUMENT AND LEAVE THE WEBSITE IMMEDIATELY. The Independent Creator hereby guarantees and attests that their date of birth is ?????, and that all the private information (including, but not limited to, an official and valid ID showing the Independent Creator’s real date of birth) that they have provided the Platform with when signing this Agreement or at a later date, is true, accurate, complete and up-to-date.</li>
  <li><strong> EDAD LEGAL</strong> Al firmar este documento, el Creador Independiente, afirma haber alcanzado la mayoría de edad (18 años) y que no se encuentra incurso en ningún tipo de incapacidad intelectual que le impida la firma de este documento. SI NO ASÍ, CIERRE ESTE DOCUMENTO Y SALGA INMEDIATAMENTE DEL SITIO WEB. Por la presente, el Creador Independiente garantiza que toda la información proporcionada relativa a su identificación oficial que muestre su fecha de nacimiento que proporcione a la plataforma a la firma de este Acuerdo o en una fecha posterior, es veraz, real, legal, completa y actualizada.</li>
  <li>ZERO TOLERANCE FOR PROSTITUTION, SEX TRAFFICKING AND PAEDOPHILIA Using our Platform in any way whatsoever to engage in, take part in, assist, support or somehow facilitate any act of prostitution (to prostitute yourself or a third party), sex trafficking of children or adults or paedophilia is strictly prohibited. This prohibition includes, but is not limited to: Exchanging any personal contact information with one or more of our users or have some kind of communication with them which could potentially result in a face-to-face meeting involving you and any other user(s); Discussing in any way with one or more of our users any type of transaction whatsoever, whether monetary or otherwise, involving the use of any service or interface not provided by the Website; Forcing anyone to perform on our Website for any reason whatsoever or forcing them to somehow take part in it; Remember that we will fully cooperate with any criminal investigation carried out by any official authority regarding any case of suspected prostitution, sex trafficking or paedophilia. If you witness any suspicious situations, or if you are actually the victim of such actions, please get in touch with us immediately at info@implik-2.com</li>
  <li><strong> TOLERANCIA CERO PARA LA PROSTITUCIÓN, LA TRATA SEXUAL Y LA PEDOFILIA</strong> Usar nuestra Plataforma de cualquier forma que implique la participación, colaboración, asistencia, apoyo, fomento y/o difusión de cualquier acto de prostitución, ya sea propia o de un tercero, trata sexual de niños/niñas, adultos o pedofilia se encuentra estrictamente prohibido. Esta prohibición incluye intercambiar cualquier tipo de información de contacto personal con uno o más de nuestros usuarios o tener algún tipo de comunicación con ellos que potencialmente lo involucre a usted y a cualquier otro usuario en estos temas; discutir de cualquier manera con uno o más de nuestros usuarios cualquier tipo de transacción, ya sea monetaria o de otro tipo, que implique actividades relacionadas con esta prohibición; obligar a cualquier persona a actuar en nuestro sitio web por cualquier motivo u obligarlos a participar de alguna manera en él.</li>
</ol>
En caso de ser necesario, denunciaremos estas prácticas y cooperaremos en cualquier investigación criminal que se lleve a cabo por cualquier autoridad oficial con respecto a cualquier caso de sospecha de prostitución, tráfico sexual o pedofilia.

Si tiene conocimiento de alguna situación sospechosa, o si realmente es víctima de tales acciones, comuníquese con nosotros de inmediato en info@implik-2.com
<ol start="3">
  <li>INDEPENDENT CREATOR’S FULL LEGAL RESPONSIBILITY The Independent Creator hereby acknowledges and accepts that the Platform allows them to license and distribute the Content directly to the Members of the Community that choose to watch said Content, and that We are not liable for the actions or inactions of any Member of the Community in connection with the Content. The Independent Creator shall be the only responsible party for any legal liability arising from the creation or distribution of their Content. Therefore, we are not responsible for the Independent Creator’s Content because our business is not (and will not be) the creation of Content, so consequently we cannot be held responsible for anything regarding the Content or any activity on our Website. We are not responsible for any inaccurate, incorrecto, offensive, inappropriate or defamatory Content that may be released or shared on the Platform. You will in all circumstances and scenarios be the only responsible of the legal obligations that might arise from this agreement in your jurisdiction, including, but not limited to, having your own valid business license, paying your own taxes and taking all the necessary steps to ensure that you are legally operating as your own separate legal entity. You hereby warrant that you are the only responsible for legally obtaining and keeping up-to-date all business licenses, certificates, registrations or any other documents or permits required by national, regional or local laws relating to you generating any revenue by taking advantage of any features of your website, and that you are as well the only responsible for the payment of taxes under the applicable laws. You are also responsible for maintaining appropriate workers’ compensation coverage or insurance for you and any of your employees. You also warrant that you maintain your business premisses separate from those from Implik-2, or maintain a portion of the Independent Creator’s own residence for conducting your business; that you keep all your legal obligations related to such premisses up-to-date; and that you have yourself purchased the necessary equipment to conduct your business. You, the Independent Creator, will never be treated as or deemed an employee of the Platform for any purpose. Nothing in this Agreement or in any other binding agreement between both parties shall constitute an employee-employer, principal-agent relationship nor will it constitute a co-venture, joint venture, partnership or any other type of business association other than that of two independent contractors. Implik-2. will not make any payments on behalf of or for the benefit of the Independent Creator and no part of the Independent Creator’s revenue will be subject to withholding by VTS Media Inc. for payments related to Social Security, Medicare, FICA, VAT taxes, federal or national taxes, state taxes, local taxes, worker’s compensation, unemployment premiums or insurances, or any other payments. The Independent Creator shall have no claim against Implik-2. for any wages, vacation payments, sick leaves, Social Security benefits, worker’s compensations, unemployment benefits or any other benefits of any kind. Additionally, the Independent Creator will not be eligible for any retirement benefits, 401(k) benefits, profit sharing benefits, bonuses or any other kind of benefits to be paid, owned or owed by Implik-2. The Platform is only intended to be a third-party beneficiary of this Agreement.</li>
</ol>
<strong>3.RESPONSABILIDAD LEGAL TOTAL DEL CREADOR INDEPENDIENTE</strong> El Creador Independiente reconoce y acepta que la Plataforma le permite licenciar y distribuir el Contenido directamente a los Miembros de la Comunidad que eligen ver dicho Contenido, y que no somos responsables de las acciones o inacciones de cualquier Miembro de la Comunidad en relación con el Contenido. El Creador Independiente exime a Implik2 de cualquier responsabilidad legal derivada de sus acciones y/o contenido y será este el único responsable legal de las acciones derivadas de su creación de contenido y/o distribución.

El Creador Independiente nunca será tratado ni considerado un empleado de la Plataforma por ningún motivo. Nada en este Acuerdo o en cualquier otro acuerdo vinculante entre ambas partes constituirá una relación empleado-empleador, ni constituirá una empresa conjunta, sociedad o cualquier otro tipo de asociación comercial que no sea la de dos contratistas. Implik-2 no realizará ningún pago en nombre o en beneficio del Creador Independiente y ninguna parte de los ingresos del Creador Independiente estará sujeta a retención por parte de Implik-2 para pagos relacionados con el Seguro Social e impuestos o cualquier otro pago. El Creador Independiente no podrá reclamar por ningún salario, pago de vacaciones, licencias por enfermedad, beneficios del Seguro Social, compensaciones laborales, beneficios por desempleo o cualquier otro beneficio de cualquier tipo.

La Plataforma solo está destinada a ser un tercero beneficiario de este Acuerdo.

&nbsp;

4.- DURATION OF THIS CONTRACT This agreement shall come into effect upon the Independent Creator’s proper submission of this document and all required information and documentation and the Platform’s full approval of said submission, and it will remain enforceable until terminated by one of the parties. You, the Independent Creator, will have the right to terminate this agreement at any time by providing written notice to Us, with the termination being effective on the 16th day of your submission of the written notice. We may terminate the agreement and cancel your account at any time, at our sole discretion, with immediate effects, for any reason whatsoever or for no reason at all, including but not limited to: (1) Your breach or non compliance with this agreement, with the terms and conditions of the website or with any other applicable document; (2) Your acts or omissions constituting an illegality, dishonesty, fraud, misinterpretation, theft or breach of confidentiality,; (3) Your acts or omissions hindering Implik-2 or any of our related entities’ business, goodwill or reputation; (4) You being convicted for or suspected of a crime constituting a felony or gross misdemeanor under local, state or federal law. In case of termination of this agreement, both parties agree to pay off any financial obligations or debts they may have with each other within 30 calendar days after the termination comes into force. YOU UNDERSTAND AND AGREE THAT WE MAY WITHHOLD AS A PAYMENT FOR ANY DEMONSTRABLE LIABILITIES, DAMAGES, COSTS OR EXPENSES INCURRED BY YOU ARISING FROM OR RELATING TO YOUR BREACH OR FAILURE TO PERFORM ANY TERM OR CONDITION OF THIS AGREEMENT.

<strong>4.- DURACIÓN DE ESTE CONTRATO</strong> Este acuerdo entrará en vigencia cuando el Creador Independiente envíe este documento junto con toda la información y documentación requerida para la aprobación total de dicha presentación por parte de la Plataforma, y ​​seguirá vigente hasta que una de las partes comunique su intención de rescindirlo. El Creador Independiente tendrá derecho a rescindir este acuerdo en cualquier momento enviándonos una notificación por escrito, y la rescisión entrará en vigencia el día 16 de su envío de la notificación por escrito. Podemos rescindir el acuerdo y cancelar su cuenta en cualquier momento, a nuestro exclusivo criterio, con efectos inmediatos, por cualquier motivo o sin motivo alguno, incluidos, entre otros: (1) Su incumplimiento o incumplimiento de este acuerdo, con los términos y condiciones del sitio web o con cualquier otro documento aplicable; (2) Sus actos u omisiones que constituyan una ilegalidad, deshonestidad, fraude, mala interpretación, robo o violación de la confidencialidad; (3) Sus actos u omisiones que obstaculizan el negocio, la buena voluntad o la reputación de Implik-2 o de cualquiera de nuestras entidades relacionadas; (4) Usted es condenado o sospechoso de un acto que constituye un delito grave o un delito menos grave según la legislación vigente. En caso de rescisión de este acuerdo, ambas partes acuerdan saldar cualquier obligación financiera o deudas que puedan tener entre sí dentro de los 30 días posteriores a la rescisión. USTED ENTIENDE Y ACEPTA QUE PODEMOS RETENER CUALQUIER CANTIDAD DEBIDA COMO PAGO EN CASO DE HABER TENIDO QUE SUFRAGAR ALGÚN PAGO EN SU NOMBRE O EN CASO DE PRODUCIRSE ALGÚN DAÑO, COSTO O GASTO DEMOSTRABLE RELACIONADO CON EL INCUMPLIMIENTO DE CUALQUIER TÉRMINO O CONDICIÓN DE ESTE ACUERDO.
<ol start="5">
  <li>CONFIDENTIALITY, NON-DISCLOSURE AND PRIVACY You hereby agree that the terms of this agreement and any information related to our web interface, systems, or business (including but not limited to software, business and marketing plans, etc) is and shall always remain confidential and our own property. You shall not directly or indirectly disclose or grant access to such terms or information to any third parties without our prior written permission. With regard to the streamed, shared or released content, the Independent Creator understands and agrees that we cannot and therefore do not guarantee any confidentiality and that this Content is actually intended to be seen by anyone meeting the age requirements of our Website. We can not guarantee the privacy of the information shared by the Independent Creator with and through the Platform, including but not limited to pictures, images, live-streaming and chat conversations. We can not of course monitor how any third party uses the Information that our Independent Creators decide to share on the Platform, so we advise the Independent Creator to be cautious when deciding what to share. In addition to the above, we can not guarantee that the Independent Creator’s Content has not and will not be illegally copied or recorded for later distribution online or through any other means by a third party. The Independent Creator therefore takes the risk and exonerates the Platform from any liability regarding any claims and complaints that may arise from illegal activities performed by any third party, including but not limited to, copyright violation, invasion of privacy and any violation of intellectual property rights.</li>
  <li><strong> CONFIDENCIALIDAD, NO DIVULGACIÓN Y PRIVACIDAD</strong> Usted acepta que los términos de este acuerdo y cualquier información relacionada con nuestra interfaz web, sistemas o negocios (incluidos, entre otros, software, planes comerciales y de marketing, etc.) son permanecer confidenciales y de nuestra propiedad, incluso con posterioridad a la finalización de nuestra relación comercial. No divulgará ni otorgará acceso a dichos términos o información a terceros, directa o indirectamente, sin nuestro consentimiento previo por escrito. Con respecto al contenido transmitido, compartido o publicado, el Creador Independiente comprende y acepta que no podemos y, por lo tanto, no garantizamos ninguna confidencialidad y que este Contenido está destinado a ser visto por cualquier persona que cumpla con los requisitos de edad de nuestro sitio web. No podemos garantizar la privacidad de la información compartida por el Creador Independiente con y a través de la Plataforma, incluidas, entre otras, fotografías, imágenes, transmisión en vivo y conversaciones de chat. Por supuesto, no podemos monitorear cómo un tercero usa la Información que nuestros Creadores Independientes deciden compartir en la Plataforma, por lo que recomendamos al Creador Independiente que sea cauteloso al decidir qué compartir. Además de lo anterior, no podemos garantizar que el Contenido del Creador Independiente no se haya copiado o grabado ilegalmente para su posterior distribución en línea o por cualquier otro medio por un tercero. Por lo tanto, el Creador Independiente asume el riesgo y exonera a la Plataforma de cualquier responsabilidad con respecto a cualquier reclamo y queja que pueda surgir de actividades ilegales realizadas por un tercero, incluidas, entre otras, la violación de los derechos de autor, la invasión de la privacidad y cualquier violación de los derechos de propiedad intelectual. .</li>
  <li>NO MONITORING OF INDEPENDENT CREATORS’ CONTENT Provided that you fulfill all the conditions stated herein for the use of our Website, you shall be free to create your own original content. Therefore both parties agree that Implik-2 does not have any control over, the means or the right to control the manner or details the Independent Creator may use in giving his/her performances while using the Platform’s web interface to generate revenues under the terms of this Agreement. The parties also agree that the Independent Creator is totally free to decide when to engage in providing individual performances. The Independent Creator is free to appear on any other Websites and Platforms, and has full control over when or if he/she will access the Website and distribute some Content. The Independent Creator understands that they have full control over their use of the Platform, including making sure that said use complies with the applicable local, state and federal law as well as with the Terms and Conditions of this Platform. The Independent Creator hereby guarantees their Content will not violate any intellectual property rights or any other applicable laws. If the Independent Creator is not sure whether their Content is in compliance with the law ar not, they must consult a legal adviser before publishing it. You further agree that you shall solely rely on your own invention, imagination, and talent while generating content, and that you shall be the only one to exercise your own artistic control over all elements of the performance, except if we or any other third party detect a possible breach of this agreement, the Terms and Conditions of the Website or any legal regulation, in which case the Platform has the right to intervene, censor the content, terminate the account or take other necessary steps.</li>
  <li><strong> NO SUPERVISIÓN DEL CONTENIDO DE CREADORES INDEPENDIENTES </strong>Siempre que cumpla con todas las condiciones aquí establecidas para el uso de nuestro sitio web, tendrá la libertad de crear su propio contenido original. Por lo tanto, ambas partes acuerdan que Implik-2 no tiene ningún control sobre los medios o el derecho de controlar la forma o los detalles que el Creador independiente puede usar para realizar sus actuaciones mientras usa la interfaz web de la Plataforma para generar ingresos según los términos de este acuerdo. Las partes también acuerdan que el Creador Independiente es totalmente libre de decidir cuándo participar en la prestación de actuaciones individuales. El Creador independiente es libre de aparecer en cualquier otro sitio web y plataforma, y ​​tiene control total sobre cuándo o si accederá al sitio web y distribuirá algún contenido. El Creador Independiente entiende que tiene control total sobre su uso de la Plataforma, cumpliendo los términos y condiciones de esta en todo caso. El Creador Independiente garantiza por la presente que su Contenido no violará ningún derecho de propiedad intelectual o cualquier otra ley aplicable. Si el Creador Independiente no está seguro de si su Contenido cumple con la ley o no, debe consultar a un asesor legal antes de publicarlo. Además, acepta que dependerá únicamente de su propia invención, imaginación y talento mientras genera contenido, y que será el único en ejercer su propio control artístico sobre todos los elementos de la actuación, excepto si nosotros o cualquier otro tercero detecta un posible incumplimiento de este acuerdo, los Términos y Condiciones del Sitio Web o cualquier reglamento legal, en cuyo caso la Plataforma tiene derecho a intervenir, censurar el contenido, dar de baja la cuenta o realizar las gestiones que considere oportunas.</li>
  <li>ACCOUNTS Shared Accounts. In the event that the Independent Creator shares the Account (defined below) with any other user, no matter how briefly, at any time and for any reason, the Independent Creator understands and acknowledges that all tokens received in that Account paid out by the Operators observing the payment details stated for the holder of the Account.. As used herein "Account" shall refer to the Platform account for which Independent Creator is executing this Agreement. As used herein, "Accountholder" shall refer to the holder of the email address on file for such Account. In the event that Independent Creator and the Accountholder are not the same person, Independent Creator understands and agrees that any agreement between Independent Creator and the Accountholder for the division of compensation received while sharing the Account is solely between Independent Creator and such Accountholder. Independent Creator agrees that Independent Creator is solely responsible for resolving all disputes with other users with whom Independent Creator shares the Account. Independent Creator hereby acknowledges that the Platform will bear no responsibility to Independent Creator in the event that the Accountholder does not compensate Independent Creator in the amount Independent Creator believes Independent Creator is owed or at all. I Independent Creator further acknowledges and agrees that the Operators will not share any personal or payment details of the Accountholder with Independent Creator for any reason except the information that Independent Creator may be able to access by virtue of having access to the Account. Independent Creator acknowledges that only the Accountholder can obtain information pertaining to the Account, pursuant to the terms of the Platform's Privacy Policy. Studio Accounts. If the Account is registered in a studio account with the Platform, Independent Creator understands and agrees that the studio, and not Independent Creator, is the owner of the Account and may add individuals to or remove individuals, including Independent Creator, from the Account at any time without Independent Creator's knowledge and/or permission. Independent Creator hereby acknowledges that the Platform will bear no responsibility to Independent Creator in the event that the studio to which the Account belongs does not compensate Independent Creator in the amount Independent Creator believes Independent Creator is owed or at all. Independent Creator understands that if the Account is in a studio account, all tokens received by the Account will be automatically transferred to the studio account. To be clear, an account is not in a studio if the tokens must be moved manually to another account for payout; tokens in studio accounts all automatically transfer to the studio.</li>
  <li><strong> CUENTAS </strong>En el caso de que el Creador Independiente comparta la Cuenta con cualquier otro usuario, sin importar cuán brevemente, en cualquier momento y por cualquier motivo, el Creador Independiente entiende y reconoce que todos los tokens recibidos en esa Cuenta fueron pagados por los Operadores observando los detalles de pago indicados para el titular de la Cuenta. Como se explica en este documento, "Cuenta" se referirá a la cuenta de la Plataforma para la cual el Creador Independiente está ejecutando este Acuerdo. Como se explica en este documento, "Titular de la cuenta" se referirá al titular de la dirección de correo electrónico registrada para dicha Cuenta. En el caso de que el Creador Independiente y el Titular de la Cuenta no sean la misma persona, el Creador Independiente entiende y acepta que cualquier acuerdo entre el Creador Independiente y el Titular de la Cuenta es únicamente entre el Creador Independiente y dicho Titular de la Cuenta. El Creador Independiente acepta es él el único responsable de resolver las disputas que se desarrollen con otros creadores con los que comparta la cuenta. Por la presente, el Creador Independiente reconoce que la Plataforma no tendrá ninguna responsabilidad entre las disputas del Creador Independiente y el titular de la cuenta. El Creador independiente reconoce que solo el Titular de la cuenta puede obtener información relacionada con la Cuenta, de conformidad con los términos de la Política de privacidad de la Plataforma.</li>
</ol>
Cuentas de estudio. Si la Cuenta está registrada en una cuenta de estudio de la Plataforma, el Creador independiente comprende y acepta que el estudio, y no el Creador independiente, es el propietario de la Cuenta y puede agregar o eliminar personas, incluido el Creador independiente, de la Cuenta en cualquier momento sin el conocimiento y / o permiso del Creador Independiente. Por la presente, el Creador Independiente reconoce que la Plataforma no tendrá ninguna responsabilidad ante el Creador Independiente en caso de que el estudio al que pertenece la Cuenta no compense al Creador Independiente en la cantidad que el Creador Independiente cree que se le debe o en absoluto. El Creador Independiente entiende que si la Cuenta está en una cuenta de estudio, todos los tokens recibidos por la Cuenta se transferirán automáticamente a la cuenta de estudio. Para ser claros, una cuenta no está en un estudio si los tokens deben moverse manualmente a otra cuenta para el pago; los tokens en las cuentas de estudio se transfieren automáticamente al estudio.
<ol start="8">
  <li>RIGHTS OVER THE CONTENT Independent Creators will broadcast live content in the form of video, images, sounds and/or text (herein referred to as “Content”), through the software resources the Platform makes available to them. Independent Creators retain absolute ownership of their Content and have the necessary licenses, rights and permissions to use it, and hereby enable the Platform to make use of any registered trademark, publicity and publication rights or any other property or personal rights regarding the Content in whole or in part, in order to allow the Platform to use said Content as stated in the Terms and Conditions or any other binding document of the Website. You understand that the Platform has developed an affiliate program that allows the affiliates to quickly create “white label” websites that redirect their traffic to our Website and directly to webcam rooms in our Website. The Independent Creator’s content will therefore be seen in any of our Platform’s affiliated “white label” Websites. You acknowledge that upon termination of your Account, the Content will be deleted from your Account but it will remain in possession of the people who purchased it prior to your Account being terminated. The Independent Creator acknowledges and accepts that, by distributing their Content through our Platform they are granting the Platform a royalty-free, worldwide, non-exclusive, irrevocable, sublicensable and transferable right to use, reproduce, distribute, display, modify, adapt, translate and create derivative works from the Content, in whole and in part, including without limitation, promoting our Website in any format and in any way possible. The Independent Creator grants each and every guest to the Website (or any other format or means) a non-exclusive license to access their Content through our Platform and use, show and play the Content as permitted by our Terms and Conditions and the features of the Website. All licenses granted by the Independent Creator are perpetual and irrevocable.</li>
  <li><strong> DERECHOS SOBRE EL CONTENIDO</strong> Los Creadores Independientes transmitirán contenido en vivo en forma de video, imágenes, sonidos y / o texto (en adelante, "Contenido"), a través de los recursos de software que la Plataforma pone a su disposición. Los Creadores independientes conservan la propiedad absoluta de su Contenido y tienen las licencias, derechos y permisos necesarios para usarlo, y por la presente permiten que la Plataforma haga uso de cualquier marca registrada, derechos de publicidad y publicación o cualquier otra propiedad o derechos personales con respecto al Contenido en su totalidad o en parte, para permitir que la Plataforma use dicho Contenido como se establece en los Términos y Condiciones o cualquier otro documento vinculante del Sitio Web. El Creador Independiente reconoce y acepta que, al distribuir su Contenido a través de nuestra Plataforma, está otorgando a la Plataforma un derecho libre de regalías, mundial, no exclusivo, irrevocable, sublicenciable y transferible para usar, reproducir, distribuir, mostrar, modificar, adaptar, traducir y crear trabajos derivados del Contenido, en su totalidad y en parte, incluyendo, sin limitación, la promoción de nuestro sitio web en cualquier formato y de cualquier forma posible. El Creador Independiente otorga a todos y cada uno de los visitantes del Sitio Web (o cualquier otro formato o medio) una licencia no exclusiva para acceder a su Contenido a través de nuestra Plataforma y usar, mostrar y reproducir el Contenido según lo permitido por nuestros Términos y Condiciones y las características de el sitio web. Todas las licencias otorgadas por el Creador Independiente son perpetuas e irrevocables.</li>
  <li>NATURE OF THE CONTENT The Platform can not control or censor its Independent Creators’ content prior to its release, but we reserve the right to do so at any time, without notice, for any reason, specially (but not limited to) in case of a breach of one or more of the following conditions: You warrant that any content that you create and release through our Platform’s systems systems will not cause any damage to the systems and will not violate any applicable laws, rules, regulations or public policies that may govern the content so delivered. You shall not promote content not related to our Website or our affiliate members, whether by chat, by text, or by any other means. You shall not be under the influence of alcohol or any illegal drug or substance while giving any performance or creating any type of content. While performing, you shall not have any animal appear on cam. While performing, you shall not have any firearms, guns or any other kind of arms appear on cam. While performing, you shall not engage in any kind of fraudulent activity (i.e. any activity that may result in complaints, chargebacks, that may be deemed inappropriate or even illegal) While performing, you shall not violate any laws regarding obscenity, minors or sex trafficking, as expressely stated in section 2. of this agreement. You will not reveal your real name, your real personal contact information or any other kind of private information; You understand as well that you can not appear on the Platform with any third party whose presence in it has not been approved beforehand by the Website in writing. Violation of these conditions will result in termination of this Agreement and the permanent termination of your account. Additionally, we reserve the right to withhold payments if any of these conditions are violated.</li>
  <li><strong> NATURALEZA DEL CONTENIDO</strong> La Plataforma no puede controlar ni censurar el contenido de sus Creadores independientes antes de su lanzamiento, pero nos reservamos el derecho de hacerlo en un momento posterior, sin previo aviso, por cualquier motivo, especialmente en caso de incumplimiento de una o más de las siguientes condiciones: Usted garantiza que cualquier contenido que cree y publique a través de los sistemas de nuestra Plataforma no causará ningún daño a los sistemas y no violará las leyes, normativas o regulaciones aplicables que puede regir el contenido. No promocionará contenido que no esté relacionado con nuestro sitio web o nuestros miembros afiliados, ya sea por chat, por mensaje de texto o por cualquier otro medio. No debe estar bajo la influencia del alcohol o cualquier droga o sustancia ilegal mientras realiza una actuación o crea cualquier tipo de contenido. Mientras actúas, no aparecerá ningún animal en la cámara. Mientras actúas, no deberás tener armas de fuego, pistolas o cualquier otro tipo de armas en la cámara. Mientras actúe, no deberá participar en ningún tipo de actividad fraudulenta (es decir, cualquier actividad que pueda resultar en quejas, devoluciones de cargo, que puedan considerarse inapropiadas o incluso ilegales), como se indica expresamente en el apartado 2. de este contrato. No revelará su nombre real, su información de contacto personal real o cualquier otro tipo de información privada; También comprende que no puede aparecer en la Plataforma con ningún tercero cuya presencia en la misma no haya sido previamente aprobada por el Sitio Web por escrito. La violación de estas condiciones resultará en la terminación de este Acuerdo y la terminación permanente de su cuenta. Además, nos reservamos el derecho de retener pagos si se viola alguna de estas condiciones.</li>
  <li>CREATING CONTENT FOR OTHER WEBSITES You have the right to create and share content through other websites during the term of this Agreement, therefore not being bound by any kind of exclusivity clause. However, while in any way using our web interface, you are strictly prohibited from engaging in any promotion of any non-Implik-2 website or product. You are allowed to own and operate your own website as well, provided that you do not advertise it on our Website and that you do not try to encourage this Platform’s Users or Independent Creators to visit your personal website instead.</li>
  <li><strong> CREACIÓN DE CONTENIDO PARA OTROS SITIOS WEB</strong> Tiene derecho a crear y compartir contenido a través de otros sitios web durante la vigencia de este Acuerdo, por lo que no está sujeto a ningún tipo de cláusula de exclusividad. Sin embargo, mientras utiliza nuestra interfaz web de alguna manera, tiene estrictamente prohibido participar en cualquier promoción de cualquier sitio web o producto que no sea de Implik-2. También se le permite poseer y operar su propio sitio web, siempre que no lo anuncie en nuestro sitio web y que no intente alentar a los usuarios o creadores independientes de esta plataforma a que visiten su sitio web personal.</li>
  <li>DISCLAIMER. LIMITATION OF LIABILITY. Implik-2 provides its web interface as well as its own technology, website and systems, on an “as-is” basis, with no guarantees of accuracy, completeness, results or reliability. We also disclaim and make no warranties or indemnities of any kind, express or implied, including but not limited to, any warranty related to the performance, merchantability, fitness for a particular purpose, title and non-infringement, or any other express or implied warranty of any kind whatsoever. Under no circumstances will Implik-2 be liable to its Independent Creators or any third party for any unforeseeable or unintentional damages or breaches of this agreement arising out of its performance of said agreement. Under no circumstances will Implik-2 be liable to its Independent Creators or any third party for any consequential, incidental, special, punitive, loss or damages, even if advised of the possibility of such damages. To the maximum extent permitted by law, the Independent Creator releases the Website and its related entities, successors, and other affiliates from any liability whatsoever, and hereby waives any and all claims or causes of action of any type against the Website or any of its related entities, successors, or affiliates for any liability, claim, cost, injury, loss, or damage of any kind arising out of or in connection with the subject matter of this Agreement or the Independent Creator’s relationship with the Platform. These include but are not limited to any claim, cost, injury, loss, or damage related to personal injuries, death, damage to or destruction of property, rights of publicity or privacy, defamation or portrayal in a false light, whether under a theory of contact, warranty, tort (including negligence, whether active, passive, or imputed), strict liability, product liability, contribution or any other theory. The Platform reserves the right to seek all remedies legally available for any damages made to it or its related entities, successors and affiliates or to its systems caused by any action or breach of this Agreement by the Independent Creator, including but not limited to misrepresentations by the Independent Creator regarding age, eligibility or availability. Also, the Platform reserves the right to block the Independent Creator’s total or partial access to the Website.</li>
  <li><strong> LIMITACIÓN DE RESPONSABILIDAD.</strong> Implik-2 proporciona su interfaz web, así como su propia tecnología, sitio web y sistemas, sin garantías de precisión, integridad, resultados o fiabilidad. También renunciamos y no ofrecemos garantías o indemnizaciones de ningún tipo, expresas o implícitas, incluidas, entre otras, cualquier garantía relacionada con el rendimiento, comerciabilidad, idoneidad para un propósito particular, título y no infracción, o cualquier otra expresa o implícita garantía de cualquier tipo. Bajo ninguna circunstancia Implik-2 será responsable ante sus Creadores Independientes o cualquier tercero por cualquier daño o incumplimiento imprevisto o involuntario de este acuerdo que surja de su cumplimiento de dicho acuerdo. Bajo ninguna circunstancia Implik-2 será responsable ante sus Creadores Independientes o cualquier tercero por cualquier pérdida o daño consecuente, incidental, especial, punitivo, incluso si se le advierte de la posibilidad de tales daños. En la medida máxima permitida por la ley, el Creador Independiente libera al Sitio Web y sus entidades relacionadas, sucesores y otros afiliados de cualquier responsabilidad, y por la presente renuncia a todos y cada uno de los reclamos o causas de acción de cualquier tipo contra el Sitio Web o cualquiera de sus entidades relacionadas, sucesores o afiliados por cualquier responsabilidad, reclamo, costo, lesión, pérdida o daño de cualquier tipo que surja de o en conexión con el tema de este Acuerdo o la relación del Creador Independiente con la Plataforma. Estos incluyen, entre otros, cualquier reclamo, coste, lesión, pérdida o daño relacionado con lesiones personales, muerte, daño o destrucción de la propiedad, derechos de publicidad o privacidad, difamación, agravio (incluida negligencia, ya sea activa, pasiva o imputada). La Plataforma se reserva el derecho de buscar todos los remedios legalmente disponibles por cualquier daño causado a ella o sus entidades relacionadas, sucesores y afiliados o a sus sistemas causados ​​por cualquier acción o incumplimiento de este Acuerdo por parte del Creador Independiente, incluyendo pero no limitado a tergiversaciones por el Creador Independiente con respecto a la edad, elegibilidad o disponibilidad. Además, la Plataforma se reserva el derecho de bloquear el acceso total o parcial del Creador Independiente al Sitio Web.</li>
  <li>INDEMNIFICATION The Independent Creator agrees to hold harmless, indemnify and defend the Website and its related entities, successors, and affiliates from and against any claims or causes of action of any kind whatsoever brought in by any other entity directly or indirectly in any lawsuit or other legal or administrative proceeding or action (including any civil, criminal, or other proceeding or action) that may in any way arise out of or be related to the Independent Creator’s breach or violation of any term or condition of this Agreement, to the Independent Creator’s performance of this Agreement, or to the Independent Creator’s other actions in any way relating to any subject matter of this Agreement, including, without limitation, right of publicity claims, invasion of privacy claims, defamation claims, sexual harassment claims, claims arising under the Family Medical Leave Act (FMLA), the Equal Pay Act (EPA), the Employee Retirement Income Security Act (ERISA), the Worker Adjustment and Retraining Notification (WARN) Act, or the Age Discrimination in Employment Act (ADEA), injuries (both physical and emotional), negligence, intellectual property, claims relating to disease or illness (including STD's), pregnancy, and any other claims under federal, state, local, or foreign law that may be legally waived and released; however, the identification of specific statutes is for purposes of example only, and the omission of any specific statute or law shall not limit the scope of this general release in any manner. Independent Creator agrees that in the event that Independent Creator appears on camera with any third party as permitted by this Agreement, Independent Creator does so at Independent Creator's own risk and acknowledges that the Company will not, and is under no obligation to, do any medical testing of such third party. Independent Creator further releases the Releasees from any claim in connection with the disbursal of any payment from a Community Member to Independent Creator's user account or the account of a third party on whose account Independent Creator may appear so long as the Releasees make a good faith effort to disburse the payment using the payment instructions on file for the applicable account.</li>
  <li><strong> INDEMNIZACIÓN</strong> El Creador Independiente se compromete a mantener indemne, indemnizar y defender el sitio web y sus entidades relacionadas, sucesores y afiliados de y contra cualquier reclamo o causa de acción de cualquier tipo que sea presentada por cualquier otra entidad directa o indirectamente en cualquier demanda u otro procedimiento o acción legal o administrativa (incluido cualquier procedimiento o acción civil, penal o de otro tipo) que de alguna manera pueda surgir de o estar relacionado con el incumplimiento o violación del Creador Independiente de cualquier término o condición de este Acuerdo. El Creador Independiente acepta que en el caso de que aparezca ante la cámara con un tercero según lo permitido por este Acuerdo, el Creador Independiente lo hace bajo su propio riesgo y reconoce que Implik-2 no tiene ningún tipo de responsabilidad.</li>
  <li>AMENDMENTS ON THIS AGREEMENT. SEVERABILITY. The terms of this Agreement may be amended or modified by the Website at its sole discretion, but the changing/amending of this agreement will be published and properly announced in the website, indicating the date of the publication. Within the following 15 calendar days the Independent Creator will have the right to refuse the changes and ask for his/her account to be terminated by writing to info@implik-2.com. After those 15 natural days the new Agreement will come into force, and all those Independent Creators who have not officially refused to accept the amendments will be automatically understood to have accepted them. If any provision of this Agreement is found to be unenforceable, the remainder of the Document shall remain intact and enforceable to the fullest extent permitted by law, while the unenforceable provision shall be deemed modified to the limited extent required to permit its enforcement in a manner most closely representing the intention of the Parties expressed in this Agreement.</li>
  <li><strong> ENMIENDAS A ESTE ACUERDO. DIVISIBILIDAD.</strong> Los términos de este Acuerdo pueden ser enmendados o modificados por el sitio web a su entera discreción, pero el cambio / enmienda de este acuerdo se publicará y anunciará adecuadamente en el sitio web, indicando la fecha de publicación. Dentro de los siguientes 15 días calendario, el Creador Independiente tendrá derecho a rechazar los cambios y solicitar la cancelación de su cuenta escribiendo a info@implik-2.com. Pasados ​​esos 15 días naturales entrará en vigencia el nuevo Acuerdo, y se entenderá automáticamente que las han aceptado todos aquellos Creadores Independientes que no se hayan negado oficialmente a aceptar las modificaciones. Si se determina que alguna disposición de este Acuerdo es inaplicable, el resto del Documento permanecerá intacto.</li>
  <li>CHOICE OF LAW Jurisdiction/Venue. Subject to the arbitration clause above, Independent Creator and the Company irrevocably submit to the jurisdiction of the courts located in Reno, Nevada, and agree that all disputes arising under this Agreement shall be governed by the laws of the State of Nevada, USA, excluding its conflict of laws provisions. In the event of Independent Creator's actual, alleged or threatened breach of the Program Rules above or any other obligation in this Agreement, the Company shall be entitled to seek injunctive relief against the Independent Creator in any court having competent jurisdiction over the matter. By Independent Creator's electronic signature on this Agreement, Independent Creator hereby represents, covenants, and warrants that Independent Creator has the ability to grant all rights granted herein, and that there are no agreements or other legal impediments which render or may render Independent Creator's acceptance of this Agreement invalid, unlawful or avoidable. Independent Creator agrees that this Agreement is intended to be governed by the Electronic Signatures in Global and National Commerce Act (the "E-Sign Act") and that by typing my name below, I intend it to stand in the place of a manual signature and be equally as binding on Independent Creator as if Independent Creator had signed this document manually. Independent Creator understands that Independent Creator may retain a paper copy of this transaction for Independent Creator's personal records and that Independent Creator has the right to withdraw Independent Creator's consent to using the E-Sign Act by emailing the Platform at info@vtsmedia.com, at which time Independent Creator will immediately cease using the Platform; provided however that Independent Creator understands and agrees that the withdrawal of Independent Creator's consent herein shall apply only as of the date of such withdrawal and will not affect Independent Creator's previous unrestricted grant of rights to the Company, if any, with respect to Content performed prior to the date of such withdrawal.</li>
  <li><strong> JURISDICCIÓN APLICABLE</strong> Ante cualquier controversia o disputas sobre los términos de este Acuerdo, las partes se someten expresa y voluntariamente a los Juzgados y Tribunales de Castelldefels, con renuncia expresa a cualquier otro fuero.</li>
</ol>
&nbsp;

Mediante la firma electrónica de este documento el Creador Independiente se compromete al cumplimiento de las estipulaciones de este Acuerdo en la fecha de firma del mismo. El Creador Independiente puede solicitar una copia de este Acuerdo en la dirección de correo electrónico <a href="mailto:info@implik-2.com">info@implik-2.com</a>.



                   
                </div>
              </div>    


            
            <div class="form-group required">
              <label class="col-sm-3 control-label" for="stateName">Nombre de usuario </label>
              <div class="col-sm-9">
                <input type="text" name="usernameContrato" id="usernameContrato"  class="form-control input-md">
               
              </div>
            </div>
            
            <div class="form-group required">
              <label class="col-sm-3 control-label" for="fechaNacimientoContrato">Fecha de nacimiento </label>
              <div class="col-sm-9">
                <input type="date" name="fechaNacimientoContrato" id="fechaNacimientoContrato"  class="form-control input-md" >
                
              </div>
            </div>



            <div class="form-group required">
              <label class="col-sm-3 control-label" for="fechaFirmaContrato">Fecha de firma </label>
              <div class="col-sm-9">
                <input type="date" name="fechaFirmaContrato" id="fechaFirmaContrato"  class="form-control input-md" >
                
              </div>
            </div>

              <div class="form-group">

                <div class="col-sm-12">
                    <div class="model_document_policy_checkbox">
                        <input ng-click="FirmaDocuments=!FirmaDocuments" name="releaseForm" id="releaseForm" type="checkbox" value="1">
                    </div>
                    <div class="model_document_policy">
                      Estoy de acuerdo con el acuerdo independiente de emisor/a. 

                    </div>
                </div>
                 
                <div class="col-sm-12">
                    <div class="model_document_policy_checkbox">
                        <input ng-click="readDocuments=!readDocuments" name="releaseForm" id="releaseForm" type="checkbox" value="1">
                    </div>
                    <div class="model_document_policy">
                      @lang('messages.youarethesoleownerandproducer')
                    <br/>
                    @lang('messages.youandanyothersonyourcamare')
                    <br/>
                    @lang('messages.youaregranting')
                    {{app('settings')->siteName}} @lang('messages.therighttoshowordisplay')
                    </div>
                </div>
              </div>
              <div class="form-group">
             
                <div class="col-sm-12 text-center">
                  <button ng-disabled="!readDocuments || !FirmaDocuments" type="submit" class="btn btn-rose btn-lg btn-block">@lang('messages.updateDocuments')</button>
                </div>
              </div>
            </form>
            
            @else 

                @if(trim($cuentaestatus) != "active")
              <form class="form-horizontal" action="/models/dashboard/account-settings/documents" enctype="multipart/form-data" method="post">

                <fieldset class="form-group">
                      <label class="col-sm-12 control-label input-lg" style="text-align: left;"> Foto del DNI: </label>

                 <!-- <div class="col-sm-9">
                      <span class="">Para poder recibir ingresos hay que añadir la foto del DNI por las 2 caras, para confirmar la mayoria de edad.</span> -->
                  </div>
              

                </fieldset>

                <fieldset class="form-group">
                    <div class="col-sm-3">
                        <label>@lang('messages.idImage') </label>  
                    </div>
                    <div class="col-sm-9 text-center">
                      <input name="idImage" id="idImage" type="file" accept="image/*">
                      <br />
                      @if($document->idImage && file_exists(public_path($document->idImage)))
                      <img src="{{asset($document->idImage)}}?v={{uniqid()}}" class="img-responsive">
                      @endif
                    </div>
                </fieldset>
                <br />

                <fieldset class="form-group">
                    <div class="col-sm-3">
                        <label>@lang('messages.idImage2')</label>  
                    </div>
                    <div class="col-sm-9 text-center">
                      <input name="idImage2" id="idImage2" type="file" accept="image/*">
                      <br />
                      @if($document->idImage2 && file_exists(public_path($document->idImage2)))
                      <img src="{{asset($document->idImage2)}}?v={{uniqid()}}" class="img-responsive">
                      @endif
                    </div>
                </fieldset>
                <br />
                <fieldset class="form-group">
                    <div class="col-sm-3">
                        <label>@lang('messages.faceid')</label>  
                    </div>
                    <div class="col-sm-9 text-center">
                      <input name="faceId" id="faceId" type="file" accept="image/*">
                      <br />
                      @if($document->faceId && file_exists(public_path($document->faceId)))
                      <img src="{{asset($document->faceId)}}?v={{uniqid()}}" class="img-responsive">
                      @endif
                    </div>
                </fieldset>
<br>

              <fieldset class="form-group">
                <h2 class="  input-lg text-center">Acuerdo independiente de emisor/a</h2>
                <div class="col-sm-11" style="height: 400px;
    overflow: auto;
    margin-left: 50px;
    border: 1px solid;">

<strong>Acuerdo independiente de emisor/a: </strong>

This electronic agreement is a legally binding and enforceable contract (referred to herein as the “Agreement”, “Document”) between you (“Independent Creator”, “Studio”, “you”, “your”, “they”) and Implik-2 Spain (“Website”, “Platform”, “we”, “us”). By providing your electronic signature and all the required information and documents you are actually agreeing to be bound by this Agreement in its entirety and accepting all the provisions herein contained, and you acknowledge that this Agreement is intended to be governed by the Electronic Signatures in Global and National Commerce Act. By entering into this Agreement you understand that you are requesting permission to access the software facilities operated by Implik-2 to stream your live, interactive webcam shows as well as to upload and distribute recorded content (such as videos, images and chat texts) to other users of this Platform. You therefore acknowledge that the Platform will only provide you with the technical functionalities necessary for you to market your own content, and that therefore the Platform will not be liable for any of your actions or inactions or those of other Independent Creators, Users or third parties. As described in more detail in the Terms and Conditions of this Platform, the Platform and its Website (as defined here) constitute an online Platform that provides social media-like services, including a chat with text and image options through which anyone accessing the Platform (whether it be a “Member of the Community” or a “User”) shall create and share online with fellow Community Members audio and video files as well as live streaming which may include, a the Member of the Community’s election, adult content. The Platform allows for the live broadcast of this Content as well as the communication between the Independent Creator and the Members of the Community allowing them to share entertainment and interaction by supplying the required software for the live broadcast of such content. Implik-2 operates the Website Platforme which simply manages the technical, organizational and contractual frameworks required to provide you and let you use the content; in other words, the Platform only works to maintain and develop the technical means that allow you to see the content published by other Users and Independent Creators, and to let you interact with the Independent Creators during their live-streaming interactive sessions.

Este acuerdo electrónico es un contrato legalmente vinculante y ejecutable (denominado en este documento el "Acuerdo", "Documento") entre usted ("Creador independiente", "Studio", "usted", "su", "ellos") y Implik-2 España ("Sitio web", "Plataforma", "nosotros", "nos"). Al proporcionar su firma electrónica y toda la información y documentos requeridos, acepta estar obligado por este Acuerdo en su totalidad y todas las disposiciones aquí contenidas. Al firmar este acuerdo, usted comprende que está accediendo a las instalaciones de software operadas por Implik-2 con el fin de transmitir en vivo sus programas interactivos de cámara web, así como para cargar y distribuir contenido grabado como videos, imágenes y textos de chat entre otros a otros usuarios de esta Plataforma. Por lo tanto, reconoce que la Plataforma solo le proporcionará las funcionalidades técnicas necesarias para poder comercializar su contenido y que esta no será responsable de ninguna de las acciones u omisiones de otros creadores independientes, usuarios o terceros. Como se describe con más detalle en los Términos y condiciones, tanto la Plataforma como su sitio web proporcionan un servicio en línea similar a las redes sociales, incluido un chat con opciones de texto e imagen a través del cual cualquier persona que acceda a la Plataforma, ya sea un "Miembro de la Comunidad" o un "Usuario”, creará y compartirá en línea con otros miembros de la comunidad archivos de audio y vídeo, así como transmisión en vivo que puede incluir, a elección del miembro de la comunidad, contenido para adultos. La Plataforma permite la transmisión en vivo de este contenido, así como la comunicación entre el creador independiente y los miembros de la comunidad, permitiéndoles compartir entretenimiento e interacción.   Implik-2 gestiona la Plataforma de sitios web que administra los marcos técnicos, organizativos y contractuales requeridos para proporcionarle y permitirle usar el contenido; en otras palabras, la Plataforma solo trabaja para mantener y desarrollar los medios técnicos que le permiten ver el contenido publicado por otros usuarios y creadores independientes, e interactuar con estos durante sus sesiones interactivas en vivo.
<ol>
  <li>LEGAL AGE By signing this document you, the Independent Creator, confirm that you have reached the age of majority in your jurisdiction, which will be at least 18 years of age or the legal age in your location (i.e. “Age Majority”), whichever figure is higher, and that you are under no national, regional or local legal provision that might somehow prohibit you from entering this agreement. IF THAT IS NOT THE CASE, PLEASE CLOSE THIS DOCUMENT AND LEAVE THE WEBSITE IMMEDIATELY. The Independent Creator hereby guarantees and attests that their date of birth is ?????, and that all the private information (including, but not limited to, an official and valid ID showing the Independent Creator’s real date of birth) that they have provided the Platform with when signing this Agreement or at a later date, is true, accurate, complete and up-to-date.</li>
  <li><strong> EDAD LEGAL</strong> Al firmar este documento, el Creador Independiente, afirma haber alcanzado la mayoría de edad (18 años) y que no se encuentra incurso en ningún tipo de incapacidad intelectual que le impida la firma de este documento. SI NO ASÍ, CIERRE ESTE DOCUMENTO Y SALGA INMEDIATAMENTE DEL SITIO WEB. Por la presente, el Creador Independiente garantiza que toda la información proporcionada relativa a su identificación oficial que muestre su fecha de nacimiento que proporcione a la plataforma a la firma de este Acuerdo o en una fecha posterior, es veraz, real, legal, completa y actualizada.</li>
  <li>ZERO TOLERANCE FOR PROSTITUTION, SEX TRAFFICKING AND PAEDOPHILIA Using our Platform in any way whatsoever to engage in, take part in, assist, support or somehow facilitate any act of prostitution (to prostitute yourself or a third party), sex trafficking of children or adults or paedophilia is strictly prohibited. This prohibition includes, but is not limited to: Exchanging any personal contact information with one or more of our users or have some kind of communication with them which could potentially result in a face-to-face meeting involving you and any other user(s); Discussing in any way with one or more of our users any type of transaction whatsoever, whether monetary or otherwise, involving the use of any service or interface not provided by the Website; Forcing anyone to perform on our Website for any reason whatsoever or forcing them to somehow take part in it; Remember that we will fully cooperate with any criminal investigation carried out by any official authority regarding any case of suspected prostitution, sex trafficking or paedophilia. If you witness any suspicious situations, or if you are actually the victim of such actions, please get in touch with us immediately at info@implik-2.com</li>
  <li><strong> TOLERANCIA CERO PARA LA PROSTITUCIÓN, LA TRATA SEXUAL Y LA PEDOFILIA</strong> Usar nuestra Plataforma de cualquier forma que implique la participación, colaboración, asistencia, apoyo, fomento y/o difusión de cualquier acto de prostitución, ya sea propia o de un tercero, trata sexual de niños/niñas, adultos o pedofilia se encuentra estrictamente prohibido. Esta prohibición incluye intercambiar cualquier tipo de información de contacto personal con uno o más de nuestros usuarios o tener algún tipo de comunicación con ellos que potencialmente lo involucre a usted y a cualquier otro usuario en estos temas; discutir de cualquier manera con uno o más de nuestros usuarios cualquier tipo de transacción, ya sea monetaria o de otro tipo, que implique actividades relacionadas con esta prohibición; obligar a cualquier persona a actuar en nuestro sitio web por cualquier motivo u obligarlos a participar de alguna manera en él.</li>
</ol>
En caso de ser necesario, denunciaremos estas prácticas y cooperaremos en cualquier investigación criminal que se lleve a cabo por cualquier autoridad oficial con respecto a cualquier caso de sospecha de prostitución, tráfico sexual o pedofilia.

Si tiene conocimiento de alguna situación sospechosa, o si realmente es víctima de tales acciones, comuníquese con nosotros de inmediato en info@implik-2.com
<ol start="3">
  <li>INDEPENDENT CREATOR’S FULL LEGAL RESPONSIBILITY The Independent Creator hereby acknowledges and accepts that the Platform allows them to license and distribute the Content directly to the Members of the Community that choose to watch said Content, and that We are not liable for the actions or inactions of any Member of the Community in connection with the Content. The Independent Creator shall be the only responsible party for any legal liability arising from the creation or distribution of their Content. Therefore, we are not responsible for the Independent Creator’s Content because our business is not (and will not be) the creation of Content, so consequently we cannot be held responsible for anything regarding the Content or any activity on our Website. We are not responsible for any inaccurate, incorrecto, offensive, inappropriate or defamatory Content that may be released or shared on the Platform. You will in all circumstances and scenarios be the only responsible of the legal obligations that might arise from this agreement in your jurisdiction, including, but not limited to, having your own valid business license, paying your own taxes and taking all the necessary steps to ensure that you are legally operating as your own separate legal entity. You hereby warrant that you are the only responsible for legally obtaining and keeping up-to-date all business licenses, certificates, registrations or any other documents or permits required by national, regional or local laws relating to you generating any revenue by taking advantage of any features of your website, and that you are as well the only responsible for the payment of taxes under the applicable laws. You are also responsible for maintaining appropriate workers’ compensation coverage or insurance for you and any of your employees. You also warrant that you maintain your business premisses separate from those from Implik-2, or maintain a portion of the Independent Creator’s own residence for conducting your business; that you keep all your legal obligations related to such premisses up-to-date; and that you have yourself purchased the necessary equipment to conduct your business. You, the Independent Creator, will never be treated as or deemed an employee of the Platform for any purpose. Nothing in this Agreement or in any other binding agreement between both parties shall constitute an employee-employer, principal-agent relationship nor will it constitute a co-venture, joint venture, partnership or any other type of business association other than that of two independent contractors. Implik-2. will not make any payments on behalf of or for the benefit of the Independent Creator and no part of the Independent Creator’s revenue will be subject to withholding by VTS Media Inc. for payments related to Social Security, Medicare, FICA, VAT taxes, federal or national taxes, state taxes, local taxes, worker’s compensation, unemployment premiums or insurances, or any other payments. The Independent Creator shall have no claim against Implik-2. for any wages, vacation payments, sick leaves, Social Security benefits, worker’s compensations, unemployment benefits or any other benefits of any kind. Additionally, the Independent Creator will not be eligible for any retirement benefits, 401(k) benefits, profit sharing benefits, bonuses or any other kind of benefits to be paid, owned or owed by Implik-2. The Platform is only intended to be a third-party beneficiary of this Agreement.</li>
</ol>
<strong>3.RESPONSABILIDAD LEGAL TOTAL DEL CREADOR INDEPENDIENTE</strong> El Creador Independiente reconoce y acepta que la Plataforma le permite licenciar y distribuir el Contenido directamente a los Miembros de la Comunidad que eligen ver dicho Contenido, y que no somos responsables de las acciones o inacciones de cualquier Miembro de la Comunidad en relación con el Contenido. El Creador Independiente exime a Implik2 de cualquier responsabilidad legal derivada de sus acciones y/o contenido y será este el único responsable legal de las acciones derivadas de su creación de contenido y/o distribución.

El Creador Independiente nunca será tratado ni considerado un empleado de la Plataforma por ningún motivo. Nada en este Acuerdo o en cualquier otro acuerdo vinculante entre ambas partes constituirá una relación empleado-empleador, ni constituirá una empresa conjunta, sociedad o cualquier otro tipo de asociación comercial que no sea la de dos contratistas. Implik-2 no realizará ningún pago en nombre o en beneficio del Creador Independiente y ninguna parte de los ingresos del Creador Independiente estará sujeta a retención por parte de Implik-2 para pagos relacionados con el Seguro Social e impuestos o cualquier otro pago. El Creador Independiente no podrá reclamar por ningún salario, pago de vacaciones, licencias por enfermedad, beneficios del Seguro Social, compensaciones laborales, beneficios por desempleo o cualquier otro beneficio de cualquier tipo.

La Plataforma solo está destinada a ser un tercero beneficiario de este Acuerdo.

&nbsp;

4.- DURATION OF THIS CONTRACT This agreement shall come into effect upon the Independent Creator’s proper submission of this document and all required information and documentation and the Platform’s full approval of said submission, and it will remain enforceable until terminated by one of the parties. You, the Independent Creator, will have the right to terminate this agreement at any time by providing written notice to Us, with the termination being effective on the 16th day of your submission of the written notice. We may terminate the agreement and cancel your account at any time, at our sole discretion, with immediate effects, for any reason whatsoever or for no reason at all, including but not limited to: (1) Your breach or non compliance with this agreement, with the terms and conditions of the website or with any other applicable document; (2) Your acts or omissions constituting an illegality, dishonesty, fraud, misinterpretation, theft or breach of confidentiality,; (3) Your acts or omissions hindering Implik-2 or any of our related entities’ business, goodwill or reputation; (4) You being convicted for or suspected of a crime constituting a felony or gross misdemeanor under local, state or federal law. In case of termination of this agreement, both parties agree to pay off any financial obligations or debts they may have with each other within 30 calendar days after the termination comes into force. YOU UNDERSTAND AND AGREE THAT WE MAY WITHHOLD AS A PAYMENT FOR ANY DEMONSTRABLE LIABILITIES, DAMAGES, COSTS OR EXPENSES INCURRED BY YOU ARISING FROM OR RELATING TO YOUR BREACH OR FAILURE TO PERFORM ANY TERM OR CONDITION OF THIS AGREEMENT.

<strong>4.- DURACIÓN DE ESTE CONTRATO</strong> Este acuerdo entrará en vigencia cuando el Creador Independiente envíe este documento junto con toda la información y documentación requerida para la aprobación total de dicha presentación por parte de la Plataforma, y ​​seguirá vigente hasta que una de las partes comunique su intención de rescindirlo. El Creador Independiente tendrá derecho a rescindir este acuerdo en cualquier momento enviándonos una notificación por escrito, y la rescisión entrará en vigencia el día 16 de su envío de la notificación por escrito. Podemos rescindir el acuerdo y cancelar su cuenta en cualquier momento, a nuestro exclusivo criterio, con efectos inmediatos, por cualquier motivo o sin motivo alguno, incluidos, entre otros: (1) Su incumplimiento o incumplimiento de este acuerdo, con los términos y condiciones del sitio web o con cualquier otro documento aplicable; (2) Sus actos u omisiones que constituyan una ilegalidad, deshonestidad, fraude, mala interpretación, robo o violación de la confidencialidad; (3) Sus actos u omisiones que obstaculizan el negocio, la buena voluntad o la reputación de Implik-2 o de cualquiera de nuestras entidades relacionadas; (4) Usted es condenado o sospechoso de un acto que constituye un delito grave o un delito menos grave según la legislación vigente. En caso de rescisión de este acuerdo, ambas partes acuerdan saldar cualquier obligación financiera o deudas que puedan tener entre sí dentro de los 30 días posteriores a la rescisión. USTED ENTIENDE Y ACEPTA QUE PODEMOS RETENER CUALQUIER CANTIDAD DEBIDA COMO PAGO EN CASO DE HABER TENIDO QUE SUFRAGAR ALGÚN PAGO EN SU NOMBRE O EN CASO DE PRODUCIRSE ALGÚN DAÑO, COSTO O GASTO DEMOSTRABLE RELACIONADO CON EL INCUMPLIMIENTO DE CUALQUIER TÉRMINO O CONDICIÓN DE ESTE ACUERDO.
<ol start="5">
  <li>CONFIDENTIALITY, NON-DISCLOSURE AND PRIVACY You hereby agree that the terms of this agreement and any information related to our web interface, systems, or business (including but not limited to software, business and marketing plans, etc) is and shall always remain confidential and our own property. You shall not directly or indirectly disclose or grant access to such terms or information to any third parties without our prior written permission. With regard to the streamed, shared or released content, the Independent Creator understands and agrees that we cannot and therefore do not guarantee any confidentiality and that this Content is actually intended to be seen by anyone meeting the age requirements of our Website. We can not guarantee the privacy of the information shared by the Independent Creator with and through the Platform, including but not limited to pictures, images, live-streaming and chat conversations. We can not of course monitor how any third party uses the Information that our Independent Creators decide to share on the Platform, so we advise the Independent Creator to be cautious when deciding what to share. In addition to the above, we can not guarantee that the Independent Creator’s Content has not and will not be illegally copied or recorded for later distribution online or through any other means by a third party. The Independent Creator therefore takes the risk and exonerates the Platform from any liability regarding any claims and complaints that may arise from illegal activities performed by any third party, including but not limited to, copyright violation, invasion of privacy and any violation of intellectual property rights.</li>
  <li><strong> CONFIDENCIALIDAD, NO DIVULGACIÓN Y PRIVACIDAD</strong> Usted acepta que los términos de este acuerdo y cualquier información relacionada con nuestra interfaz web, sistemas o negocios (incluidos, entre otros, software, planes comerciales y de marketing, etc.) son permanecer confidenciales y de nuestra propiedad, incluso con posterioridad a la finalización de nuestra relación comercial. No divulgará ni otorgará acceso a dichos términos o información a terceros, directa o indirectamente, sin nuestro consentimiento previo por escrito. Con respecto al contenido transmitido, compartido o publicado, el Creador Independiente comprende y acepta que no podemos y, por lo tanto, no garantizamos ninguna confidencialidad y que este Contenido está destinado a ser visto por cualquier persona que cumpla con los requisitos de edad de nuestro sitio web. No podemos garantizar la privacidad de la información compartida por el Creador Independiente con y a través de la Plataforma, incluidas, entre otras, fotografías, imágenes, transmisión en vivo y conversaciones de chat. Por supuesto, no podemos monitorear cómo un tercero usa la Información que nuestros Creadores Independientes deciden compartir en la Plataforma, por lo que recomendamos al Creador Independiente que sea cauteloso al decidir qué compartir. Además de lo anterior, no podemos garantizar que el Contenido del Creador Independiente no se haya copiado o grabado ilegalmente para su posterior distribución en línea o por cualquier otro medio por un tercero. Por lo tanto, el Creador Independiente asume el riesgo y exonera a la Plataforma de cualquier responsabilidad con respecto a cualquier reclamo y queja que pueda surgir de actividades ilegales realizadas por un tercero, incluidas, entre otras, la violación de los derechos de autor, la invasión de la privacidad y cualquier violación de los derechos de propiedad intelectual. .</li>
  <li>NO MONITORING OF INDEPENDENT CREATORS’ CONTENT Provided that you fulfill all the conditions stated herein for the use of our Website, you shall be free to create your own original content. Therefore both parties agree that Implik-2 does not have any control over, the means or the right to control the manner or details the Independent Creator may use in giving his/her performances while using the Platform’s web interface to generate revenues under the terms of this Agreement. The parties also agree that the Independent Creator is totally free to decide when to engage in providing individual performances. The Independent Creator is free to appear on any other Websites and Platforms, and has full control over when or if he/she will access the Website and distribute some Content. The Independent Creator understands that they have full control over their use of the Platform, including making sure that said use complies with the applicable local, state and federal law as well as with the Terms and Conditions of this Platform. The Independent Creator hereby guarantees their Content will not violate any intellectual property rights or any other applicable laws. If the Independent Creator is not sure whether their Content is in compliance with the law ar not, they must consult a legal adviser before publishing it. You further agree that you shall solely rely on your own invention, imagination, and talent while generating content, and that you shall be the only one to exercise your own artistic control over all elements of the performance, except if we or any other third party detect a possible breach of this agreement, the Terms and Conditions of the Website or any legal regulation, in which case the Platform has the right to intervene, censor the content, terminate the account or take other necessary steps.</li>
  <li><strong> NO SUPERVISIÓN DEL CONTENIDO DE CREADORES INDEPENDIENTES </strong>Siempre que cumpla con todas las condiciones aquí establecidas para el uso de nuestro sitio web, tendrá la libertad de crear su propio contenido original. Por lo tanto, ambas partes acuerdan que Implik-2 no tiene ningún control sobre los medios o el derecho de controlar la forma o los detalles que el Creador independiente puede usar para realizar sus actuaciones mientras usa la interfaz web de la Plataforma para generar ingresos según los términos de este acuerdo. Las partes también acuerdan que el Creador Independiente es totalmente libre de decidir cuándo participar en la prestación de actuaciones individuales. El Creador independiente es libre de aparecer en cualquier otro sitio web y plataforma, y ​​tiene control total sobre cuándo o si accederá al sitio web y distribuirá algún contenido. El Creador Independiente entiende que tiene control total sobre su uso de la Plataforma, cumpliendo los términos y condiciones de esta en todo caso. El Creador Independiente garantiza por la presente que su Contenido no violará ningún derecho de propiedad intelectual o cualquier otra ley aplicable. Si el Creador Independiente no está seguro de si su Contenido cumple con la ley o no, debe consultar a un asesor legal antes de publicarlo. Además, acepta que dependerá únicamente de su propia invención, imaginación y talento mientras genera contenido, y que será el único en ejercer su propio control artístico sobre todos los elementos de la actuación, excepto si nosotros o cualquier otro tercero detecta un posible incumplimiento de este acuerdo, los Términos y Condiciones del Sitio Web o cualquier reglamento legal, en cuyo caso la Plataforma tiene derecho a intervenir, censurar el contenido, dar de baja la cuenta o realizar las gestiones que considere oportunas.</li>
  <li>ACCOUNTS Shared Accounts. In the event that the Independent Creator shares the Account (defined below) with any other user, no matter how briefly, at any time and for any reason, the Independent Creator understands and acknowledges that all tokens received in that Account paid out by the Operators observing the payment details stated for the holder of the Account.. As used herein "Account" shall refer to the Platform account for which Independent Creator is executing this Agreement. As used herein, "Accountholder" shall refer to the holder of the email address on file for such Account. In the event that Independent Creator and the Accountholder are not the same person, Independent Creator understands and agrees that any agreement between Independent Creator and the Accountholder for the division of compensation received while sharing the Account is solely between Independent Creator and such Accountholder. Independent Creator agrees that Independent Creator is solely responsible for resolving all disputes with other users with whom Independent Creator shares the Account. Independent Creator hereby acknowledges that the Platform will bear no responsibility to Independent Creator in the event that the Accountholder does not compensate Independent Creator in the amount Independent Creator believes Independent Creator is owed or at all. I Independent Creator further acknowledges and agrees that the Operators will not share any personal or payment details of the Accountholder with Independent Creator for any reason except the information that Independent Creator may be able to access by virtue of having access to the Account. Independent Creator acknowledges that only the Accountholder can obtain information pertaining to the Account, pursuant to the terms of the Platform's Privacy Policy. Studio Accounts. If the Account is registered in a studio account with the Platform, Independent Creator understands and agrees that the studio, and not Independent Creator, is the owner of the Account and may add individuals to or remove individuals, including Independent Creator, from the Account at any time without Independent Creator's knowledge and/or permission. Independent Creator hereby acknowledges that the Platform will bear no responsibility to Independent Creator in the event that the studio to which the Account belongs does not compensate Independent Creator in the amount Independent Creator believes Independent Creator is owed or at all. Independent Creator understands that if the Account is in a studio account, all tokens received by the Account will be automatically transferred to the studio account. To be clear, an account is not in a studio if the tokens must be moved manually to another account for payout; tokens in studio accounts all automatically transfer to the studio.</li>
  <li><strong> CUENTAS </strong>En el caso de que el Creador Independiente comparta la Cuenta con cualquier otro usuario, sin importar cuán brevemente, en cualquier momento y por cualquier motivo, el Creador Independiente entiende y reconoce que todos los tokens recibidos en esa Cuenta fueron pagados por los Operadores observando los detalles de pago indicados para el titular de la Cuenta. Como se explica en este documento, "Cuenta" se referirá a la cuenta de la Plataforma para la cual el Creador Independiente está ejecutando este Acuerdo. Como se explica en este documento, "Titular de la cuenta" se referirá al titular de la dirección de correo electrónico registrada para dicha Cuenta. En el caso de que el Creador Independiente y el Titular de la Cuenta no sean la misma persona, el Creador Independiente entiende y acepta que cualquier acuerdo entre el Creador Independiente y el Titular de la Cuenta es únicamente entre el Creador Independiente y dicho Titular de la Cuenta. El Creador Independiente acepta es él el único responsable de resolver las disputas que se desarrollen con otros creadores con los que comparta la cuenta. Por la presente, el Creador Independiente reconoce que la Plataforma no tendrá ninguna responsabilidad entre las disputas del Creador Independiente y el titular de la cuenta. El Creador independiente reconoce que solo el Titular de la cuenta puede obtener información relacionada con la Cuenta, de conformidad con los términos de la Política de privacidad de la Plataforma.</li>
</ol>
Cuentas de estudio. Si la Cuenta está registrada en una cuenta de estudio de la Plataforma, el Creador independiente comprende y acepta que el estudio, y no el Creador independiente, es el propietario de la Cuenta y puede agregar o eliminar personas, incluido el Creador independiente, de la Cuenta en cualquier momento sin el conocimiento y / o permiso del Creador Independiente. Por la presente, el Creador Independiente reconoce que la Plataforma no tendrá ninguna responsabilidad ante el Creador Independiente en caso de que el estudio al que pertenece la Cuenta no compense al Creador Independiente en la cantidad que el Creador Independiente cree que se le debe o en absoluto. El Creador Independiente entiende que si la Cuenta está en una cuenta de estudio, todos los tokens recibidos por la Cuenta se transferirán automáticamente a la cuenta de estudio. Para ser claros, una cuenta no está en un estudio si los tokens deben moverse manualmente a otra cuenta para el pago; los tokens en las cuentas de estudio se transfieren automáticamente al estudio.
<ol start="8">
  <li>RIGHTS OVER THE CONTENT Independent Creators will broadcast live content in the form of video, images, sounds and/or text (herein referred to as “Content”), through the software resources the Platform makes available to them. Independent Creators retain absolute ownership of their Content and have the necessary licenses, rights and permissions to use it, and hereby enable the Platform to make use of any registered trademark, publicity and publication rights or any other property or personal rights regarding the Content in whole or in part, in order to allow the Platform to use said Content as stated in the Terms and Conditions or any other binding document of the Website. You understand that the Platform has developed an affiliate program that allows the affiliates to quickly create “white label” websites that redirect their traffic to our Website and directly to webcam rooms in our Website. The Independent Creator’s content will therefore be seen in any of our Platform’s affiliated “white label” Websites. You acknowledge that upon termination of your Account, the Content will be deleted from your Account but it will remain in possession of the people who purchased it prior to your Account being terminated. The Independent Creator acknowledges and accepts that, by distributing their Content through our Platform they are granting the Platform a royalty-free, worldwide, non-exclusive, irrevocable, sublicensable and transferable right to use, reproduce, distribute, display, modify, adapt, translate and create derivative works from the Content, in whole and in part, including without limitation, promoting our Website in any format and in any way possible. The Independent Creator grants each and every guest to the Website (or any other format or means) a non-exclusive license to access their Content through our Platform and use, show and play the Content as permitted by our Terms and Conditions and the features of the Website. All licenses granted by the Independent Creator are perpetual and irrevocable.</li>
  <li><strong> DERECHOS SOBRE EL CONTENIDO</strong> Los Creadores Independientes transmitirán contenido en vivo en forma de video, imágenes, sonidos y / o texto (en adelante, "Contenido"), a través de los recursos de software que la Plataforma pone a su disposición. Los Creadores independientes conservan la propiedad absoluta de su Contenido y tienen las licencias, derechos y permisos necesarios para usarlo, y por la presente permiten que la Plataforma haga uso de cualquier marca registrada, derechos de publicidad y publicación o cualquier otra propiedad o derechos personales con respecto al Contenido en su totalidad o en parte, para permitir que la Plataforma use dicho Contenido como se establece en los Términos y Condiciones o cualquier otro documento vinculante del Sitio Web. El Creador Independiente reconoce y acepta que, al distribuir su Contenido a través de nuestra Plataforma, está otorgando a la Plataforma un derecho libre de regalías, mundial, no exclusivo, irrevocable, sublicenciable y transferible para usar, reproducir, distribuir, mostrar, modificar, adaptar, traducir y crear trabajos derivados del Contenido, en su totalidad y en parte, incluyendo, sin limitación, la promoción de nuestro sitio web en cualquier formato y de cualquier forma posible. El Creador Independiente otorga a todos y cada uno de los visitantes del Sitio Web (o cualquier otro formato o medio) una licencia no exclusiva para acceder a su Contenido a través de nuestra Plataforma y usar, mostrar y reproducir el Contenido según lo permitido por nuestros Términos y Condiciones y las características de el sitio web. Todas las licencias otorgadas por el Creador Independiente son perpetuas e irrevocables.</li>
  <li>NATURE OF THE CONTENT The Platform can not control or censor its Independent Creators’ content prior to its release, but we reserve the right to do so at any time, without notice, for any reason, specially (but not limited to) in case of a breach of one or more of the following conditions: You warrant that any content that you create and release through our Platform’s systems systems will not cause any damage to the systems and will not violate any applicable laws, rules, regulations or public policies that may govern the content so delivered. You shall not promote content not related to our Website or our affiliate members, whether by chat, by text, or by any other means. You shall not be under the influence of alcohol or any illegal drug or substance while giving any performance or creating any type of content. While performing, you shall not have any animal appear on cam. While performing, you shall not have any firearms, guns or any other kind of arms appear on cam. While performing, you shall not engage in any kind of fraudulent activity (i.e. any activity that may result in complaints, chargebacks, that may be deemed inappropriate or even illegal) While performing, you shall not violate any laws regarding obscenity, minors or sex trafficking, as expressely stated in section 2. of this agreement. You will not reveal your real name, your real personal contact information or any other kind of private information; You understand as well that you can not appear on the Platform with any third party whose presence in it has not been approved beforehand by the Website in writing. Violation of these conditions will result in termination of this Agreement and the permanent termination of your account. Additionally, we reserve the right to withhold payments if any of these conditions are violated.</li>
  <li><strong> NATURALEZA DEL CONTENIDO</strong> La Plataforma no puede controlar ni censurar el contenido de sus Creadores independientes antes de su lanzamiento, pero nos reservamos el derecho de hacerlo en un momento posterior, sin previo aviso, por cualquier motivo, especialmente en caso de incumplimiento de una o más de las siguientes condiciones: Usted garantiza que cualquier contenido que cree y publique a través de los sistemas de nuestra Plataforma no causará ningún daño a los sistemas y no violará las leyes, normativas o regulaciones aplicables que puede regir el contenido. No promocionará contenido que no esté relacionado con nuestro sitio web o nuestros miembros afiliados, ya sea por chat, por mensaje de texto o por cualquier otro medio. No debe estar bajo la influencia del alcohol o cualquier droga o sustancia ilegal mientras realiza una actuación o crea cualquier tipo de contenido. Mientras actúas, no aparecerá ningún animal en la cámara. Mientras actúas, no deberás tener armas de fuego, pistolas o cualquier otro tipo de armas en la cámara. Mientras actúe, no deberá participar en ningún tipo de actividad fraudulenta (es decir, cualquier actividad que pueda resultar en quejas, devoluciones de cargo, que puedan considerarse inapropiadas o incluso ilegales), como se indica expresamente en el apartado 2. de este contrato. No revelará su nombre real, su información de contacto personal real o cualquier otro tipo de información privada; También comprende que no puede aparecer en la Plataforma con ningún tercero cuya presencia en la misma no haya sido previamente aprobada por el Sitio Web por escrito. La violación de estas condiciones resultará en la terminación de este Acuerdo y la terminación permanente de su cuenta. Además, nos reservamos el derecho de retener pagos si se viola alguna de estas condiciones.</li>
  <li>CREATING CONTENT FOR OTHER WEBSITES You have the right to create and share content through other websites during the term of this Agreement, therefore not being bound by any kind of exclusivity clause. However, while in any way using our web interface, you are strictly prohibited from engaging in any promotion of any non-Implik-2 website or product. You are allowed to own and operate your own website as well, provided that you do not advertise it on our Website and that you do not try to encourage this Platform’s Users or Independent Creators to visit your personal website instead.</li>
  <li><strong> CREACIÓN DE CONTENIDO PARA OTROS SITIOS WEB</strong> Tiene derecho a crear y compartir contenido a través de otros sitios web durante la vigencia de este Acuerdo, por lo que no está sujeto a ningún tipo de cláusula de exclusividad. Sin embargo, mientras utiliza nuestra interfaz web de alguna manera, tiene estrictamente prohibido participar en cualquier promoción de cualquier sitio web o producto que no sea de Implik-2. También se le permite poseer y operar su propio sitio web, siempre que no lo anuncie en nuestro sitio web y que no intente alentar a los usuarios o creadores independientes de esta plataforma a que visiten su sitio web personal.</li>
  <li>DISCLAIMER. LIMITATION OF LIABILITY. Implik-2 provides its web interface as well as its own technology, website and systems, on an “as-is” basis, with no guarantees of accuracy, completeness, results or reliability. We also disclaim and make no warranties or indemnities of any kind, express or implied, including but not limited to, any warranty related to the performance, merchantability, fitness for a particular purpose, title and non-infringement, or any other express or implied warranty of any kind whatsoever. Under no circumstances will Implik-2 be liable to its Independent Creators or any third party for any unforeseeable or unintentional damages or breaches of this agreement arising out of its performance of said agreement. Under no circumstances will Implik-2 be liable to its Independent Creators or any third party for any consequential, incidental, special, punitive, loss or damages, even if advised of the possibility of such damages. To the maximum extent permitted by law, the Independent Creator releases the Website and its related entities, successors, and other affiliates from any liability whatsoever, and hereby waives any and all claims or causes of action of any type against the Website or any of its related entities, successors, or affiliates for any liability, claim, cost, injury, loss, or damage of any kind arising out of or in connection with the subject matter of this Agreement or the Independent Creator’s relationship with the Platform. These include but are not limited to any claim, cost, injury, loss, or damage related to personal injuries, death, damage to or destruction of property, rights of publicity or privacy, defamation or portrayal in a false light, whether under a theory of contact, warranty, tort (including negligence, whether active, passive, or imputed), strict liability, product liability, contribution or any other theory. The Platform reserves the right to seek all remedies legally available for any damages made to it or its related entities, successors and affiliates or to its systems caused by any action or breach of this Agreement by the Independent Creator, including but not limited to misrepresentations by the Independent Creator regarding age, eligibility or availability. Also, the Platform reserves the right to block the Independent Creator’s total or partial access to the Website.</li>
  <li><strong> LIMITACIÓN DE RESPONSABILIDAD.</strong> Implik-2 proporciona su interfaz web, así como su propia tecnología, sitio web y sistemas, sin garantías de precisión, integridad, resultados o fiabilidad. También renunciamos y no ofrecemos garantías o indemnizaciones de ningún tipo, expresas o implícitas, incluidas, entre otras, cualquier garantía relacionada con el rendimiento, comerciabilidad, idoneidad para un propósito particular, título y no infracción, o cualquier otra expresa o implícita garantía de cualquier tipo. Bajo ninguna circunstancia Implik-2 será responsable ante sus Creadores Independientes o cualquier tercero por cualquier daño o incumplimiento imprevisto o involuntario de este acuerdo que surja de su cumplimiento de dicho acuerdo. Bajo ninguna circunstancia Implik-2 será responsable ante sus Creadores Independientes o cualquier tercero por cualquier pérdida o daño consecuente, incidental, especial, punitivo, incluso si se le advierte de la posibilidad de tales daños. En la medida máxima permitida por la ley, el Creador Independiente libera al Sitio Web y sus entidades relacionadas, sucesores y otros afiliados de cualquier responsabilidad, y por la presente renuncia a todos y cada uno de los reclamos o causas de acción de cualquier tipo contra el Sitio Web o cualquiera de sus entidades relacionadas, sucesores o afiliados por cualquier responsabilidad, reclamo, costo, lesión, pérdida o daño de cualquier tipo que surja de o en conexión con el tema de este Acuerdo o la relación del Creador Independiente con la Plataforma. Estos incluyen, entre otros, cualquier reclamo, coste, lesión, pérdida o daño relacionado con lesiones personales, muerte, daño o destrucción de la propiedad, derechos de publicidad o privacidad, difamación, agravio (incluida negligencia, ya sea activa, pasiva o imputada). La Plataforma se reserva el derecho de buscar todos los remedios legalmente disponibles por cualquier daño causado a ella o sus entidades relacionadas, sucesores y afiliados o a sus sistemas causados ​​por cualquier acción o incumplimiento de este Acuerdo por parte del Creador Independiente, incluyendo pero no limitado a tergiversaciones por el Creador Independiente con respecto a la edad, elegibilidad o disponibilidad. Además, la Plataforma se reserva el derecho de bloquear el acceso total o parcial del Creador Independiente al Sitio Web.</li>
  <li>INDEMNIFICATION The Independent Creator agrees to hold harmless, indemnify and defend the Website and its related entities, successors, and affiliates from and against any claims or causes of action of any kind whatsoever brought in by any other entity directly or indirectly in any lawsuit or other legal or administrative proceeding or action (including any civil, criminal, or other proceeding or action) that may in any way arise out of or be related to the Independent Creator’s breach or violation of any term or condition of this Agreement, to the Independent Creator’s performance of this Agreement, or to the Independent Creator’s other actions in any way relating to any subject matter of this Agreement, including, without limitation, right of publicity claims, invasion of privacy claims, defamation claims, sexual harassment claims, claims arising under the Family Medical Leave Act (FMLA), the Equal Pay Act (EPA), the Employee Retirement Income Security Act (ERISA), the Worker Adjustment and Retraining Notification (WARN) Act, or the Age Discrimination in Employment Act (ADEA), injuries (both physical and emotional), negligence, intellectual property, claims relating to disease or illness (including STD's), pregnancy, and any other claims under federal, state, local, or foreign law that may be legally waived and released; however, the identification of specific statutes is for purposes of example only, and the omission of any specific statute or law shall not limit the scope of this general release in any manner. Independent Creator agrees that in the event that Independent Creator appears on camera with any third party as permitted by this Agreement, Independent Creator does so at Independent Creator's own risk and acknowledges that the Company will not, and is under no obligation to, do any medical testing of such third party. Independent Creator further releases the Releasees from any claim in connection with the disbursal of any payment from a Community Member to Independent Creator's user account or the account of a third party on whose account Independent Creator may appear so long as the Releasees make a good faith effort to disburse the payment using the payment instructions on file for the applicable account.</li>
  <li><strong> INDEMNIZACIÓN</strong> El Creador Independiente se compromete a mantener indemne, indemnizar y defender el sitio web y sus entidades relacionadas, sucesores y afiliados de y contra cualquier reclamo o causa de acción de cualquier tipo que sea presentada por cualquier otra entidad directa o indirectamente en cualquier demanda u otro procedimiento o acción legal o administrativa (incluido cualquier procedimiento o acción civil, penal o de otro tipo) que de alguna manera pueda surgir de o estar relacionado con el incumplimiento o violación del Creador Independiente de cualquier término o condición de este Acuerdo. El Creador Independiente acepta que en el caso de que aparezca ante la cámara con un tercero según lo permitido por este Acuerdo, el Creador Independiente lo hace bajo su propio riesgo y reconoce que Implik-2 no tiene ningún tipo de responsabilidad.</li>
  <li>AMENDMENTS ON THIS AGREEMENT. SEVERABILITY. The terms of this Agreement may be amended or modified by the Website at its sole discretion, but the changing/amending of this agreement will be published and properly announced in the website, indicating the date of the publication. Within the following 15 calendar days the Independent Creator will have the right to refuse the changes and ask for his/her account to be terminated by writing to info@implik-2.com. After those 15 natural days the new Agreement will come into force, and all those Independent Creators who have not officially refused to accept the amendments will be automatically understood to have accepted them. If any provision of this Agreement is found to be unenforceable, the remainder of the Document shall remain intact and enforceable to the fullest extent permitted by law, while the unenforceable provision shall be deemed modified to the limited extent required to permit its enforcement in a manner most closely representing the intention of the Parties expressed in this Agreement.</li>
  <li><strong> ENMIENDAS A ESTE ACUERDO. DIVISIBILIDAD.</strong> Los términos de este Acuerdo pueden ser enmendados o modificados por el sitio web a su entera discreción, pero el cambio / enmienda de este acuerdo se publicará y anunciará adecuadamente en el sitio web, indicando la fecha de publicación. Dentro de los siguientes 15 días calendario, el Creador Independiente tendrá derecho a rechazar los cambios y solicitar la cancelación de su cuenta escribiendo a info@implik-2.com. Pasados ​​esos 15 días naturales entrará en vigencia el nuevo Acuerdo, y se entenderá automáticamente que las han aceptado todos aquellos Creadores Independientes que no se hayan negado oficialmente a aceptar las modificaciones. Si se determina que alguna disposición de este Acuerdo es inaplicable, el resto del Documento permanecerá intacto.</li>
  <li>CHOICE OF LAW Jurisdiction/Venue. Subject to the arbitration clause above, Independent Creator and the Company irrevocably submit to the jurisdiction of the courts located in Reno, Nevada, and agree that all disputes arising under this Agreement shall be governed by the laws of the State of Nevada, USA, excluding its conflict of laws provisions. In the event of Independent Creator's actual, alleged or threatened breach of the Program Rules above or any other obligation in this Agreement, the Company shall be entitled to seek injunctive relief against the Independent Creator in any court having competent jurisdiction over the matter. By Independent Creator's electronic signature on this Agreement, Independent Creator hereby represents, covenants, and warrants that Independent Creator has the ability to grant all rights granted herein, and that there are no agreements or other legal impediments which render or may render Independent Creator's acceptance of this Agreement invalid, unlawful or avoidable. Independent Creator agrees that this Agreement is intended to be governed by the Electronic Signatures in Global and National Commerce Act (the "E-Sign Act") and that by typing my name below, I intend it to stand in the place of a manual signature and be equally as binding on Independent Creator as if Independent Creator had signed this document manually. Independent Creator understands that Independent Creator may retain a paper copy of this transaction for Independent Creator's personal records and that Independent Creator has the right to withdraw Independent Creator's consent to using the E-Sign Act by emailing the Platform at info@vtsmedia.com, at which time Independent Creator will immediately cease using the Platform; provided however that Independent Creator understands and agrees that the withdrawal of Independent Creator's consent herein shall apply only as of the date of such withdrawal and will not affect Independent Creator's previous unrestricted grant of rights to the Company, if any, with respect to Content performed prior to the date of such withdrawal.</li>
  <li><strong> JURISDICCIÓN APLICABLE</strong> Ante cualquier controversia o disputas sobre los términos de este Acuerdo, las partes se someten expresa y voluntariamente a los Juzgados y Tribunales de Castelldefels, con renuncia expresa a cualquier otro fuero.</li>
</ol>
&nbsp;

Mediante la firma electrónica de este documento el Creador Independiente se compromete al cumplimiento de las estipulaciones de este Acuerdo en la fecha de firma del mismo. El Creador Independiente puede solicitar una copia de este Acuerdo en la dirección de correo electrónico <a href="mailto:info@implik-2.com">info@implik-2.com</a>.



                   
                </div>
              </fieldset>   

<br>


            <fieldset class="form-group">
              <label class="col-sm-3 control-label" for="stateName">Nombre de usuario: </label>
              <div class="col-sm-9">
                <label>{{$document->usernameContrato}}</label>
               
              </div>
            </fieldset>
            
            <fieldset class="form-group ">
              <label class="col-sm-3 control-label" for="fechaNacimientoContrato">Fecha de nacimiento: </label>
              <div class="col-sm-9">
                <label> {{ date('d-m-Y', strtotime($document->fechaNacimientoContrato)) }}</label>   

              </div>
            </fieldset>



            <fieldset class="form-group">
              <label class="col-sm-3 control-label" for="fechaFirmaContrato">Fecha de firma: </label>
              <div class="col-sm-9">
                 <label>{{ date('d-m-Y', strtotime($document->fechaFirmaContrato)) }}</label>  
                
              </div>
            </fieldset>






                <div class="form-group">
                  <div class="col-sm-3">
                  </div>
                  <div class="col-sm-9 text-center">
                    <button type="submit" class="btn btn-rose btn-lg btn-block">@lang('messages.updateDocuments')</button>
                  </div>
                </div>
              </form>
              @else 
            <h3>@lang('messages.Lacuentayaestaactiva')</h3>
            @endif

            @endif
        </div>
      </div><!--Documents -->





    <?php } ?>
    <?php if ($action && $action == 'contact') { ?>
      <div class="mod_settings_cont">
        <div class="user-mailbox-folder-name">@lang('messages.yourContactDetails')</div>
          <table class="table table-bordered">
            <tr>
              <td class="text-right" style="width: 50%"><strong>@lang('messages.firstname')</strong></td>
              <td>{{$contact->firstName}}</td>
            </tr>
    <!--        <tr>
              <td class="text-right"><strong>Middle name</strong></td>
              <td>Middle name</td>
            </tr>-->
            <tr>
              <td class="text-right"><strong>@lang('messages.lastname')</strong></td>
              <td>{{$contact->lastName}}</td>
            </tr>
            <tr>
              <td class="text-right"><strong>@lang('messages.country')</strong></td>
              <td>{{$contact->countryName}}</td>
            </tr>
            <tr>
              <td class="text-right"><strong> @lang('messages.statename') </strong></td>
              <td>{{$contact->stateName}}</td>
            </tr>
            <tr>
              <td class="text-right"><strong>@lang('messages.city')</strong></td>
              <td>{{$contact->cityName}}</td>
            </tr>
            <tr>
              <td class="text-right"><strong>@lang('messages.zip')</strong></td>
              <td>{{$contact->zip}}</td>
            </tr>
            <tr>
              <td class="text-right"><strong>@lang('messages.address') 1</strong></td>
              <td>{{$contact->address1}}</td>
            </tr>
            <tr>
              <td class="text-right"><strong>@lang('messages.address') 2</strong></td>
              <td>{{$contact->address2}}</td>
            </tr>
            <tr>
              <td class="text-right"><strong>@lang('messages.email')</strong></td>
              <td>{{$contact->email}}</td>
            </tr>
            <tr>
              <td class="text-right"><strong>@lang('messages.mobilePhone')</strong></td>
              <td>{{$contact->mobilePhone}}</td>
            </tr>
            
          </table>
          <a class="btn center-block btn-rose" href="{{URL('models/dashboard/account-settings?action=edit-contact')}}">@lang('messages.editContactDetails')</a>
        </div>
    <?php } ?>
    <?php if ($action && $action == 'edit-contact') { ?>
      <div class="panel panel-default">
        <div class="panel-heading"> <h4>@lang('messages.editContactDetails')</h4></div>
        <div class="panel-body">
          <form class="form-horizontal" ng-submit="submitUpdateContact(frmContact)" name="frmContact" novalidate method="post">
            
            <div class="form-group required">
              <label class="col-sm-3 control-label" for="contactEmail">@lang('messages.email') </label>
              <div class="col-sm-9">
                <input type="email" name="contactEmail" class="form-control input-md" ng-model="contact.email" ng-required="true" ng-init="contact.email = '{{$contact->email}}'" ng-maxlength="50" maxlength="50">
                <span class="label label-danger" ng-show="frmContact.$submitted && frmContact.contactEmail.$error.required">@lang('messages.thisFieldIsRequired')</span>
                <span class="label label-danger" ng-show="frmContact.contactEmail.$error.email">
        Not valid email!</span>
                <span class="label label-danger" ng-show="frmContact.contactEmail.$error.maxlength">@lang('messages.emailOnlyMax50')</span>
              </div>
            </div>
            
            <div class="form-group required">
              <label class="col-sm-3 control-label" for="contactCountryId">@lang('messages.country') </label>
              <div class="col-sm-9">
                <select class="form-control input-md" name="contactCountryId" ng-model="contact.countryId" ng-init="countryInit({{$contact->countryId}})" ng-options="country.id as country.name for country in countries" ng-required="true" ng-change="changeCountry(contact.countryId)">
                  <option value="">@lang('messages.pleaseSelectCountry')</option>
                </select>
                <span class="label label-danger" ng-show="frmContact.$submitted && frmContact.contactCountryId.$error.required">@lang('messages.thisFieldIsRequired')</span>
              </div>
            </div>
            
            <div class="form-group required">
              <label class="col-sm-3 control-label" for="stateName">@lang('messages.state') </label>
              <div class="col-sm-9">
                <input type="text" name="stateName" id="contactCityName" ng-model="contact.stateName" class="form-control input-md" ng-init="contact.stateName = '{{$contact->stateName}}'" ng-required="true" maxlength="32">
                <span class="label label-danger" ng-show="frmContact.$submitted && frmContact.stateName.$error.required">@lang('messages.thisFieldIsRequired')</span>
              </div>
            </div>
            
            <div class="form-group required">
              <label class="col-sm-3 control-label" for="contactCityName">@lang('messages.city') </label>
              <div class="col-sm-9">
                <input type="text" name="cityName" id="contactCityName" ng-model="contact.cityName" class="form-control input-md" ng-init="contact.cityName = '{{$contact->cityName}}'" ng-required="true" maxlength="32">
<!--                <select class="form-control input-md" name="contactCityId" ng-model="contact.cityId" ng-init="cityInit({{$contact->stateId}}, {{$contact->cityId}})" ng-options="city.id as city.name for city in cities" ng-required="true">
                  <option value="">Please select a city</option>
                </select>-->
                <span class="label label-danger" ng-show="frmContact.$submitted && frmContact.cityName.$error.required">@lang('messages.thisFieldIsRequired')</span>
              </div>
            </div>
            
            <div class="form-group required">
              <label class="col-sm-3 control-label" for="contactZip">@lang('messages.zip') </label>
              <div class="col-sm-9">
                
                <input type="text" class="form-control input-md" name="contactZip" ng-model="contact.zip" ng-required="true" maxlength="10" ng-init="contact.zip='{{$contact->zip}}'">
                <span class="label label-danger" ng-show="frmContact.$submitted && frmContact.contactZip.$error.required">@lang('messages.thisFieldIsRequired')</span>
              </div>
            </div>
            
            <div class="form-group required">
              <label class="col-sm-3 control-label" for="contactAddress1">@lang('messages.address') 1 </label>
              <div class="col-sm-9">
                <input type="text" name="contactAddress1" class="form-control input-md" ng-model="contact.address1" maxlength="64" ng-required="true" ng-init="contact.address1='{{$contact->address1}}'">
                <span class="label label-danger" ng-show="frmContact.$submitted && frmContact.contactAddress1.$error.required">@lang('messages.thisFieldIsRequired')</span>
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-3 control-label" for="contactAddress2">@lang('messages.address') 2</label>
              <div class="col-sm-9">
                <input type="text" name="contactAddress2" class="form-control input-md" ng-model="contact.address2" maxlength="64" ng-init="contact.address2='{{$contact->address2}}'">
              </div>
            </div>
            
            
            
             <div class="form-group required">
              <label class="col-sm-3 control-label" for="contactMobilePhone">@lang('messages.mobilePhone') </label>
              <div class="col-sm-9">
                <input type="text" name="contactMobilePhone" class="form-control input-md" ng-model="contact.mobilePhone" maxlength="15" ng-init="contact.mobilePhone = '{{$contact->mobilePhone}}'" ng-pattern="/^[0-9]+$/" ng-minlength="10" ng-maxlength="15" ng-required="true">
                <span class="label label-danger" ng-show="frmContact.contactMobilePhone.$error.required">@lang('messages.phoneIsRequired')</span>
                  <span class="label label-danger" ng-show="frmContact.contactMobilePhone.$error.pattern">@lang('messages.phoneMustBeNumeric')</span>
                  <span class="label label-danger" ng-show="frmContact.contactMobilePhone.$error.minlength">@lang('messages.phoneMustMin10')</span>
              </div>
            </div>

            <div class="form-group">
              <div class="col-sm-9 col-sm-offset-3">
                <p class="alert alert-danger" ng-repeat="err in errors"><%err%></p>
              </div>
            </div>
            <div class="form-group">
              <div class="col-sm-3">
              </div>
              <div class="col-sm-9 text-center">
                
                <button type="submit" class="btn btn-rose btn-lg btn-block" ng-disabled="frmContact.$submitted && formSubmitted">@lang('messages.saveChanges')</button>
              </div>
            </div>
          </form>
        </div>
      </div><!--Edit Contact Details -->
    <?php } ?>
    <?php if ($action && $action == 'payment') { ?>
      <div class="panel panel-default">
        <div class="panel-heading"> <h4>@lang('messages.yourPaymentDetails') sdfsd</h4></div>
        <div class="panel-body">
          <table class="table table-bordered">
            <tr>
              <td class="text-right" style="width: 50%"><strong>@lang('messages.minPayment')</strong></td>
              <td>{{$paymentInfo -> minPayment}} $</td>
            </tr>
            <tr>
              <td class="text-right"><strong>Payoneer</strong></td>
              <td>{{$paymentInfo -> payoneer}}</td>
            </tr>
            <tr>
              <td class="text-right"><strong>Paypal</strong></td>
              <td>{{$paymentInfo->paypal}}</td>
            </tr>
            <tr>
              <td class="text-right"><strong>@lang('messages.bankAccount')</strong></td>
              <td>{{$paymentInfo->bankAccount}}</td>
            </tr>
          </table>
          <a href="{{URL('models/dashboard/account-settings?action=edit-payment')}}" class="btn center-block btn-rose">@lang('messages.editPaymentDetails')</a>
        </div>
      </div><!--Payment option -->
    <?php } ?>
    <?php if ($action && $action == 'edit-payment') { ?>
      <div class="panel panel-default">
        <div class="panel-heading"> <h4>@lang('messages.editPaymentDetails')</h4></div>
        <div class="panel-body">
          <form class="form-horizontal" ng-submit="submitUpdatePayment(frmPayment)" name="frmPayment" novalidate method="post" ng-init="paymentInit('{{$paymentInfo}}')">
            <div class="form-group required">
              <label class="col-sm-4 col-md-3 control-label" for="minPayment">Pago mínimo </label>
              <div class="col-sm-8 col-md-5">
                <select class="form-control input-md" name="minPayment" ng-model="payment.minPayment" ng-options="val.min as val.min + '$' for val in paymentValue" ng-required="true">
                  <option value="">@lang('messages.pleaseSelect')</option>
                </select>
                <span class="label label-danger" ng-show="frmPayment.$submitted && frmPayment.minPayment.$error.required">@lang('messages.thisFieldIsRequired')</span>
                <span class="label label-danger" ng-show="frmPayment.$submitted && errors.minPayment"><%errors.minPayment[0]%></span>
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-4 col-md-3 control-label" for="payoneer">Payoneer </label>
              <div class="col-sm-8 col-md-5">
                <input type="text" name="payoneer" class="form-control input-md" ng-model="payment.payoneer">
                <span class="label label-danger" ng-show="frmPayment.$submitted && frmPayment.payoneer.$error.required">@lang('messages.thisFieldIsRequired')</span>
                <span class="label label-danger" ng-show="frmPayment.$submitted && errors.payoneer"><%errors.payoneer[0]%></span>
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-4 col-md-3 control-label" for="paypal">Paypal </label>
              <div class="col-sm-8 col-md-5">
                <input type="text" name="paypal" class="form-control input-md" ng-model="payment.paypal">
                <span class="label label-danger" ng-show="frmPayment.$submitted && frmPayment.paypal.$error.required">@lang('messages.thisFieldIsRequired')</span>
                <span class="label label-danger" ng-show="frmPayment.$submitted && errors.paypal"><%errors.paypal[0]%></span>
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-4 col-md-3 control-label" for="bankAccount">@lang('messages.bankaccountwithcode') </label>
              <div class="col-sm-8 col-md-5">
                <input type="text" name="bankAccount" class="form-control input-md" ng-model="payment.bankAccount">
                <span class="label label-danger" ng-show="frmPayment.$submitted && frmPayment.bankAccount.$error.required">@lang('messages.thisFieldIsRequired')</span>
                <span class="label label-danger" ng-show="frmPayment.$submitted && errors.bankAccount"><%errors.bankAccount[0]%></span>
              </div>
            </div>
            <div class="text-center"><button type="submit" class="btn btn-danger btn-lg">Guardar </button></div>
          </form>
        </div>
      </div><!--Edit Payment Details -->
    <?php } ?>

    <?php if ($action && $action == 'payee-info') { ?>
      <div class="panel panel-default">
        <div class="panel-heading"> <h4>@lang('messages.payeeInfo')</h4></div>
        <div class="panel-body">
          <form class="form-horizontal" method="POST" action="{{URL('models/dashboard/account-settings/payee-info')}}">
              @include('Studio::payeeForm', ['bankTransferOptions' => $bankTransferOptions])
             <div class="text-center"><button type="submit" class="btn btn-danger btn-lg">@lang('messages.saveChanges')</button></div>
          </form>
        </div>
      </div>
    <?php } ?>  
    <?php if ($action && $action == 'direct-deposity') { ?>
      <div class="panel panel-default">
        <div class="panel-heading"> <h4>@lang('messages.directDeposit')</h4></div>
        <div class="panel-body">
          <form class="form-horizontal" method="POST" action="{{URL('models/dashboard/account-settings/direct-deposity')}}">
              @include('Studio::directDepositForm', ['directDeposit' => $directDeposit])
             <div class="text-center"><button type="submit" class="btn btn-danger btn-lg">Guardar</button></div>
          </form>
        </div>
      </div>
    <?php } ?> 
    <?php if ($action && $action == 'paxum') { ?>
      <div class="panel panel-default">
        <div class="panel-heading"> <h4>@lang('messages.paxum')</h4></div>
        <div class="panel-body">
          <form class="form-horizontal" method="POST" action="{{URL('models/dashboard/account-settings/paxum')}}">
              @include('Studio::paxumForm', ['paxum' => $paxum])
             <div class="text-center"><button type="submit" class="btn btn-danger btn-lg">@lang('messages.saveChanges')</button></div>
          </form>          
        </div>
      </div>
    <?php } ?> 

    <?php if ($action && $action == 'bitpay') { ?>
      <div class="panel panel-default">
        <div class="panel-heading"> <h4>@lang('messages.bitpay')</h4></div>
        <div class="panel-body">
          <form class="form-horizontal" method="POST" action="{{URL('models/dashboard/account-settings/bitpay')}}">
              @include('Studio::bitpayForm', ['bitpay' => $bitpay])
             <div class="text-center"><button type="submit" class="btn btn-danger btn-lg">@lang('messages.saveChanges')</button></div>
          </form>           
        </div>
      </div>
    <?php } ?> 

    <?php if ($action && $action == 'change-password') { ?>
      <div class="panel panel-default">
        <div class="panel-heading"> <h4>@lang('messages.changePassword')</h4></div>
        <div class="panel-body">
          <form class="form-horizontal" novalidate method="POST" name="passwordForm" ng-submit="submitChangePassword(passwordForm)">
            <div class="form-group required">
              <label for="oldPassword" class="col-sm-4 col-md-3 control-label">@lang('messages.oldPassword') </label>
              <div class="col-sm-8 col-md-5">
                <input class="form-control" id="oldPassword" name="oldPassword" type="password" placeholder="" ng-model="settings.password.oldPassword" ng-required="true">
                <span class="label label-danger" ng-show="passwordForm.$submitted && passwordForm.oldPassword.$error.required">@lang('messages.thisFieldIsRequired')</span>
              </div>
            </div>
            <div class="form-group required">
              <label for="newPassword" class="col-sm-4 col-md-3 control-label">@lang('messages.newPassword') </label>
              <div class="col-sm-8 col-md-5">
                <input class="form-control" id="newPassword" name="newPassword" type="password" placeholder="" ng-model="settings.password.newPassword" ng-required="true" ng-minlength="6" ng-maxlength="30">
                <span class="label label-danger" ng-show="passwordForm.$submitted && passwordForm.newPassword.$error.required">@lang('messages.thisFieldIsRequired')</span>
                <span class="label label-danger" ng-show="passwordForm.newPassword.$error.minlength">@lang('messages.passwordIsTooShort')</span>
                <span class="label label-danger" ng-show="passwordForm.newPassword.$error.maxlength">@lang('messages.passwordIsTooLong')</span>
              </div>
            </div>
            <div class="form-group required">
              <label for="newPasswordRetype" class="col-sm-4 col-md-3 control-label">@lang('messages.retypePassword') </label>
              <div class="col-sm-8 col-md-5">
                <input class="form-control" id="newPasswordRetype" name="newPasswordRetype" type="password" placeholder="" ng-model="settings.password.newPasswordRetype" ng-minlength="6" ng-maxlength="30" ng-required="true" pw-check="newPassword">
                <span class="label label-danger" ng-show="passwordForm.$submitted && passwordForm.newPasswordRetype.$error.required">@lang('messages.thisFieldIsRequired')</span>

                <span class="label label-danger" ng-show="passwordForm.newPasswordRetype.$viewValue.length > 0 && passwordForm.newPasswordRetype.$error.pwmatch">@lang('messages.retypePasswordNotMatch')</span>
              </div>
            </div>
            <div class="text-center"><button type="submit" class="btn btn-danger btn-lg">@lang('messages.saveChanges')</button></div>
          </form>
        </div>
      </div><!--Change Password -->
    <?php } ?>
    <?php if ($action && $action == 'disable-account') { ?>
      <div class="panel panel-default">
        <div class="panel-heading"> <h4>@lang('messages.disableAccount')</h4></div>
        <div class="panel-body">
          <form class="form-horizontal" method="post" ng-submit="submitDisableAccount(frmDisableAccount)" name="frmDisableAccount" novalidate>
            <div class="form-group required">
              <label for="suspendReason" class="col-sm-4 col-md-3 control-label">@lang('messages.suspensionReason') </label>
              <div class="col-sm-8 col-md-5">
                <textarea class="form-control" rows="3" name="suspendReason" id="suspend-reason" ng-model="suspend.reason" ng-required="true"></textarea>
                <span class="label label-danger" ng-show="frmDisableAccount.$submitted && frmDisableAccount.suspendReason.$error.required">@lang('messages.thisFieldIsRequired')</span>
              </div>
            </div>
            <div class="form-group required">
              <label for="suspendPass" class="col-sm-4 col-md-3 control-label">@lang('messages.enterYourPassword') </label>
              <div class="col-sm-8 col-md-5">
                <input class="form-control" id="suspendPass" name="suspendPass" ng-model="suspend.password" type="password" placeholder="" ng-required="true">
                <span class="label label-danger" ng-show="frmDisableAccount.$submitted && frmDisableAccount.suspendPass.$error.required">@lang('messages.thisFieldIsRequired')</span>
              </div>
            </div>
            <div class="form-group">
              <div class="col-sm-4 col-md-3 control-label">
              </div>
              <div class="col-sm-8 col-md-5">
                <label class="checkbox-inline">
                  <input id="suspendCheck" name="suspendCheck" value="1" ng-required="true" type="checkbox" ng-model="suspend.check">@lang('messages.iWantToSuspendMyAccount') 
                </label>
                <div class="clearfix"></div>
                <span class="label label-danger" ng-show="frmDisableAccount.$submitted && frmDisableAccount.suspendCheck.$error.required">@lang('messages.thisFieldIsRequired')</span>
              </div>
            </div>
            <div class="text-center"><button type="submit" class="btn btn-danger btn-lg" ng-disabled="frmDisableAccount.$submitted && frmDisableAccount.$valid && submitted">@lang('messages.suspendAccount')</button></div>
          </form>
        </div>
      </div> <!--Disable Account-->
    <?php } ?>

  </div> <!--user's info end-->
</div>

@endsection