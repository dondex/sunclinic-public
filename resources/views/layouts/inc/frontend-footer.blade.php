<footer class="footer mt-5 sticky-bottom shadow-sm bg-blue rounded mx-1">
        <div class="container">
            <div class="row d-flex justify-center align-items-center text-center" >
               

                <div class="col-md-4 col-sm-4 col-4">
                    <div>
                        

                        @if(Auth::check())
                            <a href="{{ url('my-appointment/' . Auth::id()) }}">
                                
                                    <i class="fas fa-clipboard-list text-white icon-size-footer pb-2"></i>
                                   
                        
                            </a>
                        @else
                            <a href="{{ route('login') }}"> <!-- Assuming you have the login route named 'login' -->
                              
                                    <i class="fas fa-clipboard-list text-white icon-size-footer pb-2"></i>
                                   
                            
                            </a>
                        @endif
                    </div>
                </div>

                <div class="col-md-4 col-sm-4 col-4">
                    <div>
                        <a href="{{ url('/') }}">
                            <i class="fas fa-home text-white icon-size-footer1 pb-2"></i>
                        </a>
                        
                    </div>
                </div>

                <div class="col-md-4 col-sm-4 col-4">
                    <div>
                        @if(Auth::check())
                            <a href="{{ url('profile/' . Auth::id()) }}">
                                <i class="fas fa-user text-white icon-size-footer pb-2"></i>
                            </a>
                        @else
                            <a href="{{ route('login') }}"> <!-- Assuming you have the login route named 'login' -->
                                <i class="fas fa-user text-white icon-size-footer pb-2"></i>
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
</footer>