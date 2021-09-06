				<div class="card shadow bg-white rounded">
                    <div class="card-body">
                        <div class="pl-3">
                            <p class="card-title" id="name" style="font-weight: bold;">@if (Auth::user()->first_name) {{ Auth::user()->first_name }} @endif @if (Auth::user()->last_name) {{ Auth::user()->last_name }} @endif</p>
                            <p class="card-subtitle mb-4" id="user_type">@role('admin')
                      		 Admin
                    			@endrole
                    			@role('mentor')
                      	 		Mentor
                    		@endrole
                    		@role('pelikulove')
                      		 Pelikulove
                    		@endrole
                    		@role('user')
                       		Student
                   			 @endrole </p>
                        </div>

                        <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist"
                            aria-orientation="vertical">
                            <a class="nav-link active" id="v-pills-profile-tab" data-toggle="pill"
                                href="#v-pills-profile" role="tab" aria-controls="v-pills-profile"
                                aria-selected="true">Profile</a>
                            <a class="nav-link" id="v-pills-courses-tab" data-toggle="pill" href="#v-pills-courses"
                                role="tab" aria-controls="v-pills-courses" aria-selected="false">My Courses</a>
                            <a class="nav-link" id="v-pills-notes-tab" data-toggle="pill" href="#v-pills-notes"
                                role="tab" aria-controls="v-pills-notes" aria-selected="false">My Notes</a>
                            <a class="nav-link" id="v-pills-settings-tab" data-toggle="pill" href="#v-pills-settings"
                                role="tab" aria-controls="v-pills-settings" aria-selected="false">Account Settings</a>
                        </div>

                    </div>

                </div>