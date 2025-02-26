  
  <footer>
                            <div class="col-md-12">
                                <div class="footer-contents">
                                    <div class="ossn-footer-menu">

                                  <!--    <a href="{{URL('/')}}">&COPY; COPYRIGHT {{app('settings')['siteName']}} </a>

                                           @foreach( app('pages') as $page )


                     @if($page->idioma == App::getLocale())
                           @if(App::getLocale() == 'es' or App::getLocale() == '')

                           <a href="{{URL('page/'.$page->alias)}}">{{$page->title}}</a>

                           @else

                           <a href="{{URL(App::getLocale().'/page/'.$page->alias)}}">{{$page->title}}</a>

                           @endif

                       
                     @endif
                  @endforeach-->
                                       


 <a class="menu-footer-powered" href="https://www.opensource-socialnetwork.org/">Powered by the Open Source Social Network.</a>
                                          
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12" style="background: #333; color: white; padding: 10px;">
                              
                              <ul class="estiloul" style="align-items: center;
                                  justify-content: center;">
                                 
                                   <li>
                                     @lang('messages.Selectyourlanguage'): 
                                   </li>
                           @if (config('locale.status') && count(config('locale.languages')) > 1)
               
                    @foreach (array_keys(config('locale.languages')) as $lang)
                        @if ($lang != App::getLocale())
                               <li class="" style="margin-right: 10px; margin-left: 3px;">
                                     <a class="back" href="{{ url('lang', [$lang]) }}"> <img width="30px" height="15px" src='{{URL("images/$lang.jpg")}}'>
                                     </a>
                              </li>
                        @endif
                    @endforeach
              
            @endif
                              </ul>
                            </div>

                            <input type="hidden" value="@if (App::getLocale()=='' ) es @else{{App::getLocale()}}@endif" id="current_idioma">
                        </footer>
