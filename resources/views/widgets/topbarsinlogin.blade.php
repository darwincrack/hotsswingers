 <?php
use App\Helpers\Session as AppSession;
use App\Helpers\Helper as AppHelper;

$userLogin = AppSession::getLoginData();

?>


                <!-- ossn topbar -->
                <div class="topbar">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-2 left-side left">
                                
                            </div>
                            <div class="col-md-7 site-name text-center hidden-xs hidden-sm">
                                
                            <div class="logo" style="width: 100%">
                                    @if(App::getLocale()=="" or App::getLocale()=="es")
                                        <a href="{{URL('/')}}" style="padding: 0;">
                                      @else
                                        <a href="{{URL('/'.App::getLocale())}}" style="padding: 0;">
                                      @endif 
                                    @if(app('settings')->logo)
                                    <img src="/uploads/{{app('settings')->logo}}" alt="{{app('settings')->siteName}}" style="width: 145px;"></a>
                                    @endif
                                  </a>
                            </div>
                            </div>
                            <div class="col-md-3 text-right right-side"></div>
                        </div>
                    </div>
                </div>
                <!-- ./ ossn topbar -->