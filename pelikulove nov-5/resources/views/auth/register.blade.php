@extends('layouts.app')

@section('template_fastload_css')
    #signUp:disabled {opacity: 0.4}
@endsection

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-6 col-sm-10 col-xs-12">
            <div class="card">
                {{-- <div class="card-header text-center">{{ __('SIGN UP for FREE access') }}</div> --}}
                <div class="card-header text-center">
                    WELCOME TO PELIKULOVE!
                    <br>
                    <span class="small">
                        <strong>
                            GET FREE ACCESS to exclusive videos feat. Pinoy artists in theater, film, videographed plays, short films and more!
                            <br>
                            Learn from Philippines' best! Nagsisimula palang tayo 🙂
                        </strong>
                    </span>
                </div>
                
                <hr>

                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf
                        <div class="form-group row">
                            <div class="col-md-8 offset-md-2">
                                <label for="name" class="col-form-label text-md-right">{{ __('Username') }}</label>
                                {{-- <span class="text-danger" style="font-size: 1.5rem">*</span> --}}
                                <input id="name" type="text"
                                    class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name"
                                    value="{{ old('name') }}" required autofocus>

                                @if ($errors->has('name'))
                                <span class="invalid-feedback">
                                    <strong>{{ $errors->first('name') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        
                        {{-- <div class="form-group row">
                            <div class="col-md-8 offset-md-2">
                                <label for="first_name" class="col-form-label text-md-right">{{ __('First Name') }}</label>
                                <input id="first_name" type="text"
                                    class="form-control{{ $errors->has('first_name') ? ' is-invalid' : '' }}" name="first_name"
                                    value="{{ old('first_name') }}">

                                @if ($errors->has('first_name'))
                                <span class="invalid-feedback">
                                    <strong>{{ $errors->first('first_name') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        
                        <div class="form-group row">
                            <div class="col-md-8 offset-md-2">
                                <label for="last_name" class="col-form-label text-md-right">{{ __('Last Name') }}</label>
                                <input id="last_name" type="text"
                                    class="form-control{{ $errors->has('last_name') ? ' is-invalid' : '' }}" name="last_name"
                                    value="{{ old('last_name') }}">

                                @if ($errors->has('last_name'))
                                <span class="invalid-feedback">
                                    <strong>{{ $errors->first('last_name') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div> --}}

                        <div class="form-group row">
                            <div class="col-md-8 offset-md-2">
                                <label for="email" class="col-form-label">{{ __('E-Mail') }}</label>
                                <input id="email" type="email"
                                    class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email"
                                    value="{{ old('email') }}" required>

                                @if ($errors->has('email'))
                                <span class="invalid-feedback">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row" id="form-show-password">
                            <div class="col-md-8 offset-md-2">
                                <label for="password" class="col-form-label">{{ __('Password') }}</label>
                                <div class="input-group" id="form-show-password">
                                    <input id="password" type="password"
                                        class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}"
                                        name="password" required>
                                    <div class="input-group-append">
                                        <div class="input-group-text"><a href=""><i class="fa fa-eye-slash"></i></a>
                                        </div>
                                    </div>
                                </div>
                                @if ($errors->has('password'))
                                <span class="invalid-feedback">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        @if(config('settings.reCaptchStatus'))
                        <br>
                        <div class="form-group row d-flex justify-content-center">
                            <div class="col-md-8 text-center">
                                <div class="g-recaptcha" data-sitekey="{{ config('settings.reCaptchSite') }}"></div>
                            </div>
                        </div>
                        @endif
                        <div class="form-group row m-3">
                            <div class="col-md-8 offset-md-2">
                                By Signing Up, you agree to our 
                                <a href="http://pelikulove.com/terms-and-conditions/">Terms and Conditions</a> and 
                                <a href="http://pelikulove.com/privacy-policy/">Privacy Policy</a>        
                            </div>
                            </label>
                        </div>
                        
                        <div class="form-group row m-3 d-flex justify-content-center">
                            <div id="container_terms" name="container_terms" class="container_terms col-md-10 mw-100" style="overflow: auto; height: 40vh; border: 1px solid #bbbbbb; ">  
                                <h4>SECTION 1. Definitions </h4>
                                <p>Help us help you. We use these terms throughout the Terms of Service. These will help you understand what we mean when we use them.</p>
                                <ol>
                                <li><b>“Site</b>” refers to www.learn.pelikulove.com.</li>
                                <li>“<b>Pelikulove,</b>” “<b>we,</b>” “<b>our,</b>” and “<b>us</b>” refer to Pelikulove Corp. which operates this Site.</li>
                                <li>“<b>Terms</b>” refers to this document, the Terms of Service.</li>
                                <li>“<b>Services</b>” refers to the tools, features, applications, data, software, and all related widgets, players, and other services provided by Pelikulove.</li>
                                <li>“<b>Agreement</b>” refers to the Terms, its conditions and notices, and all other operating rules, policies (such as the Privacy Policy), and procedures referenced into these Terms of Service. This Agreement is a legally binding contract between you and Pelikulove in relation to your use of the Site and Services.</li>
                                <li>“<b>User</b>” in general could also refer to “<b>community member</b>” or “<b>member</b>”, “<b>student,</b>” “<b>mentor</b>,” “<b>you</b>,” or “<b>your</b>”, which is any individual who has enrolled in one of our courses and has created an account in the Site. You must also be <b>at least 16 years of age to access the Site and our Services</b>.</li>
                                <li>&#8220;<b>Account</b>&#8221; represents your legal relationship with Pelikulove. A “<b>User Account</b>” represents an individual User’s authorization to log in to and use the Service and serves as a User’s identity on Pelikulove.</li>
                                <li>“<b>Content</b>” refers to (without limitation) text, data, articles, images, photographs, videos, graphics, software, applications, designs, features, and other materials that are available on the Site or otherwise available through the Service. &#8220;<b>Content</b>&#8221; also includes Services. “<b>User Content</b>” is Content, written or otherwise, created or uploaded by our Users. &#8220;<b>Your Content</b>&#8221; is Content that you create or own.</li>
                                </ol></br>
                    
                                <h4>SECTION 2. Acceptance of Use</h4>
                                <p>Please read these <a href="https://pelikulove.com/terms-and-conditions/">Terms of Service</a>, <a href="http://pelikulove.com/privacy-policy">Privacy Policy</a>, <a href="https://pelikulove.com/community-guidelines/">Community Guidelines</a>, and <a href="https://pelikulove.com/honor-code/">Honor Code</a> carefully.</p>
                                <p>By accessing or using any part of the Site, registering an account, viewing, streaming, uploading or downloading any Content from or to the Site, you have read and understood the Terms of Service and agree to be bound by these Terms. If you do not agree with all the terms and conditions of this Agreement, we advise you to immediately discontinue your access to the Site or any of our Services.</p>
                                <p>By agreeing to these Terms, you represent that you are at least 16 years of age, or the applicable age of majority in your area of residence.</p>
                                <p>You may not use our products for any illegal or unauthorized purpose nor may you, in the use of the Services, violate any laws in your area of residence (including but not limited to copyright laws). A breach or violation of any of the Terms will result in an immediate termination of your Services.</br></p>
                    
                                <h4> SECTION 3. Personal Information</h4>
                                <p>Our Privacy Policy governs your submission of personal information and non-personal information through the Site. Learn more about our <a href="https://pelikulove.com/privacy-policy/">Privacy Policy.</a></p> </br>
                    
                                <h4> SECTION 4. Fair Use Policy</h4>
                                <p>As part of your enrollment to the online course and subject to your compliance with these Terms, we grant you a personal, non-exclusive, non-transferable, limited right to access, use, display, and download the Services on a <i>single </i>computer, cell phone, television or any other similar devices at the same time. You may view, display, copy, download, and print some of the Content solely for your own personal, non-commercial use.</p>
                                <p>Except as expressly authorized by Pelikulove, you agree not to transmit, publicly display in classrooms, lectures or through other forms of instruction, publicly perform, publish, mirror such materials or content of the online course. As noted above, reproduction, copying, or redistribution for commercial purposes of any materials or design elements on this site is strictly prohibited without the express written permission of Pelikulove.</p>
                                <p>You may not, in any way, otherwise copy, reproduce, distribute, transmit, display, perform, reproduce, publish, license, modify, create derivative works from, sell, or exploit, in whole or in part, any of the Content of the Site and its Services, especially the online course.</p>
                                <p>You agree that you will create and use only one User Account, and you will not share or give access to anyone for your personal information for your account.</p>
                                <p>Pelikulove may at any time, for any reason, and without notice or liability; modify, suspend or terminate your access to the Services, or any portion thereof and/ or deactivate or delete your accounts and all related information and files in your account. We also reserve the right to refuse service to anyone for any reason at any time.</p>
                                <p>All rights not expressly granted in these Terms are reserved.</p></br>
                    
                                <h4> SECTION 5. Our Course</h4>
                                <p>5.1. Course Availability</p>
                                <p>Pelikulove’s online course is available exclusively through the Site.</p>
                                <p>We reserve the right, but are not obligated, to limit the sales of our courses to any person, geographic location or jurisdiction. We may exercise this right on a case-by-case basis. We reserve the right to limit the quantities of any course or Services that we offer. We reserve the right to discontinue any course at any time. Any offer for any course or Services made on this Site is void where prohibited.</p>
                                <p>5.2. Course Quality</p>
                                <p>We have made every effort to display as accurately as possible the colors and images of our courses that appear at the Site. We cannot guarantee that your computer monitor&#8217;s display of any color will be accurate.</p>
                                <p>5.3. Changes to the Course</p>
                                <p>We reserve the right to modify, reschedule, interrupt, or discontinue any course content such as, but not limited to, video lessons, handouts, exercises, plays-on-video, at any time at to our discretion.</p>
                                <p>5.4. Certificate of Completion, Academic Credit, and Relationship with Educational  Institutions</p>
                                <p>When you complete the course and all its requirements and pay an additional fee, you may get a Certificate of Completion signed by the mentor and Pelikulove.</p>
                                <p>Your enrollment, participation, or completion of a course does not mean you are entitled to any academic credit. Pelikulove, its mentors, and its affiliated institutions have no responsibility to issue academic credits or have any course recognized by any educational institution or accreditation organization.</p>
                                <p>Your enrollment in any course does not mean it establishes any relationship between you and any educational institution nor enrolls you in any educational institution which Pelikulove may be affiliated with.</p></br>
                    
                                <h4> SECTION 6. User Content</h4>
                                <p>Our Services enable you to share your content with Pelikulove, mentors, and/or other users. These include exercises, scripts, and other works you submit, posts you make, comments you write, and the like (&#8220;User Content&#8221;). You shall be solely responsible for the User Content you share and retain all intellectual property rights.</p>
                                <p>6.1. User Feedback and Other Submissions</p>
                                <p>If, at our request, you send certain submissions (for example script drafts) or without a request from us you send creative ideas, suggestions, proposals, plans, or other materials, whether online, by email, by postal mail, or otherwise (collectively, “feedback”), we shall ask for your consent should we wish to edit, copy, publish, distribute, translate and/or otherwise use in any medium any feedback that you forward to us.</p>
                                <p>We are and shall be under obligation (1) to maintain any feedback in confidence or (2) to respond to certain feedback.</p>
                                <p>&nbsp;</p>
                                <p>6.2. Users and Intellectual Property</p>
                                <p>We are under obligation to monitor, edit or remove User Content that we determine in our sole discretion unlawful, offensive, threatening, libelous, defamatory, pornographic, obscene or otherwise objectionable or violates any party’s intellectual property or these Terms of Service.</p>
                                <p>You agree that your comments will not violate any right of any third-party, including copyright, trademark, privacy, personality or other personal or proprietary right. You further agree that your comments will not contain libelous or otherwise unlawful, abusive or obscene material, or contain any computer virus or other malware that could in any way affect the operation of the Service or any related Site. You may not use a false e-mail address, pretend to be someone other than yourself, or otherwise mislead us or third-parties as to the origin of any comments.</p>
                                <p>You are solely responsible for any comments you make and their accuracy. We take no responsibility and assume no liability for any comments posted by you or any third-party.</p></br>
                                
                                <h4>SECTION 7. Security</h4>
                                <p>We care about your safety and security deeply because you matter to us. While we strive to protect your Account and related information, we cannot guarantee its absolute security. Please email us at pelikuloveofficial@gmail.com if you suspect any unauthorized use of your Account.</p></br>
                    
                                <h4>SECTION 8. Third-Parties</h4>
                                <p>Certain content and services available via our Services may include materials from third-parties.</p>
                                <p>8.1. Third-Party Links</p>
                                <p>Third-party links on the site may direct you to third-party sites that are not affiliated with us. We are not responsible for examining or evaluating the content or accuracy and we do not warrant and will not have any responsibility for any third-party materials or sites, or for any other materials, products, or services of third-parties.</p>
                                <p>We are not liable for any harm or damages related to the purchase or use of our Services, Content, or any other transactions made in connection with any third-party sites.</p>
                                <p>Please review carefully the third-party&#8217;s policies and practices and make sure you understand them before you engage in any transaction. Complaints, claims, concerns, or questions regarding third-party products should be directed to the third-party.</p>
                                <p>8.2. Third-Party Tools</p>
                                <p>We may provide you with access to third-party tools over which we neither monitor nor have any control nor input.</p>
                                <p>You acknowledge and agree that we provide access to such tools “as is” and “as available” without any warranties, representations or conditions of any kind and without any endorsement. We shall have no liability whatsoever arising from or relating to your use of optional third-party tools.</p>
                                <p>Any use of optional tools offered through the Site is entirely at your own risk and discretion and you should ensure that you are familiar with and approve of the terms on which tools are provided by the relevant third-party provider(s).</p> </br>
                    
                                <h4>SECTION 9. Pricing, Patronage, and Purchases on the Service</h4>
                                <p>9.1. Price Changes</p>
                                <p>Pelikulove reserves the right to change any fees at any time at its sole discretion. Any change or modification will be effective immediately upon posting through the relevant Services.</p>
                                <p>9.2. Patronage</p>
                                <p>Pelikulove encourages a patronage system wherein you may make a donation of whatever amount you are willing to give. Pelikulove will use this system to sustain the community and our projects as well as share the proceeds among the main artists who worked passionately and tirelessly to mount our projects (e.g. plays-on-video). To be a part of our patronage system, you may fill out this form and Pelikulove will email you for further instructions.</p>
                                <p>9.3. Paid Services</p>
                                <p>We offer our Services for a fee. These Services include our Course and its inclusions, Certificate of Completion, Membership and Renewal, Mentor Feedback, and Plays-on-Video. All fees are quoted in Philippine Peso, unless otherwise stated. You are responsible for paying all fees and applicable taxes on time with a payment mechanism associated with the applicable paid Services. If your payment method fails or your account is past due, we may collect fees using other collection mechanisms. Fees may vary based on your location and other factors.</p>
                                <p>9.4. Payment Information</p>
                                <p>We reserve the right to refuse any order you place with us. We may, in our sole discretion, limit or cancel the Services purchased per person. These restrictions may include orders placed by or under the same User Account, the same credit card, and/or orders that use the same billing and/or shipping address.</p>
                                <p>In the event that we make a change to or cancel an order, we may attempt to notify you by contacting the e-mail and/or billing address/phone number provided at the time the order was made.</p>
                                <p>You agree to provide current, complete and accurate purchase and account information for all purchases made at our Site. You agree to promptly update your account and other information, including your email address and credit card numbers and expiration dates, so that we can complete your transactions and contact you as needed.</p>
                                <p>&nbsp;</p>
                                <p>9.5. Refunds</p>
                                <p>Pelikulove is not liable for any refunds for Membership or other purchases on the Site. Payments are nonrefundable and there are no refunds for any or all Paid Services.</p></br>
                    
                                <h4>SECTION 10. Prohibited uses</h4>
                                <p>In addition to other prohibitions as set forth in the Terms of Service, you are prohibited from using the Site or its Content:</p>
                                <ol>
                                <li>for any unlawful purpose;</li>
                                <li>to solicit others to perform or participate in any unlawful acts;</li>
                                <li>to violate any international, national, provincial or state regulations, rules, laws, or local ordinances;</li>
                                <li>to infringe upon or violate our intellectual property rights or the intellectual     property rights of others;</li>
                                <li>to harass, abuse, insult, harm, defame, slander, disparage, intimidate, or     discriminate based on gender, sexual orientation, religion, ethnicity, race, age, national origin, or disability;</li>
                                <li>to submit false or misleading information;</li>
                                <li>to upload or transmit viruses or any other type of malicious code that will or may be used in any way that will affect the functionality or operation of the Service or of any related site, other sites, or the Internet;</li>
                                <li>to collect or track the personal information of others;</li>
                                <li>to spam, phish, pharm, pretext, spider, crawl, or scrape;</li>
                                <li>for any obscene or immoral purpose; or</li>
                                <li>to interfere with or circumvent the security features of the Service or any related site, other sites, or the Internet.</li>
                                </ol>
                                <p>We reserve the right to terminate your use of the Service and access to the Site for violating any of the prohibited uses.</p></br>
                    
                                <h4>SECTION 11. Disclaimer of Warranties; Limitation of Liability</h4>
                                <p>We do not guarantee, represent or warrant that your use of our Service will be uninterrupted, timely, secure or error-free.</p>
                                <p>You agree that from time to time we may remove any service per our discretion and careful evaluation especially such Services that will be lined up for improvement, or may be proven harmful or ineffective within the platform, for indefinite periods of time or cancel the service altogether at any time. This will be done with prior notice to all users except in emergency cases or matters concerning national security. In times like this, it is in our best interest to keep you informed and shall notify you after the fact.</p>
                                <p>You expressly agree that your use of, or inability to use, the Service is at your sole risk. The Services delivered to you through the Site are (except as expressly stated by us) provided &#8216;as is&#8217; and &#8216;as available&#8217; for your use, without any representation, warranties or conditions of any kind, either expressed or implied, including all implied warranties or conditions of profitability, profitable quality, durability, title, and non-infringement.</p>
                                <p>In no case shall Pelikulove Corp., our directors, officers, employees, partners, affiliates, agents, contractors, subcontractors, interns, suppliers, service providers or licensors be liable for any injury, loss, claim, or any direct, indirect, incidental, punitive, special, or consequential damages of any kind, including, (without limitation) lost profits, lost revenue, lost savings, loss of data, replacement costs, or any similar damages, whether based in contract, tort (including negligence), strict liability or otherwise, arising from your use of any of our Services or any products procured using the Site, or for any other claim related in any way to your use of our Services or any product, including, but not limited to, any errors or omissions in any content, or any loss or damage of any kind incurred as a result of the use of the Service or any Content (or product) posted, transmitted, or otherwise made available via the Service, even if advised of their possibility. Because some jurisdictions do not allow the exclusion or the limitation of liability for consequential or incidental damages, in such jurisdictions, our liability shall be limited to the maximum extent permitted by law.</p></br>
                    
                                <h4>SECTION 12. Indemnification</h4>
                                <p>You agree to indemnify, defend and hold harmless Pelikulove Corp., our directors, officers, employees, partners, affiliates, agents, contractors, subcontractors, interns, suppliers, service providers or licensors, harmless from any claim or demand, including reasonable attorneys’ fees, made by any third-party due to or arising out of your breach of these Terms of Service or the documents they incorporate by reference, or your violation of any law or the rights of a third-party.</p></br>
                    
                                <h4>SECTION 13. Severability</h4>
                                <p>In the event that any provision of these Terms of Service is determined to be unlawful, void or unenforceable, such provision shall nonetheless be enforceable to the fullest extent permitted by applicable law, and the unenforceable portion shall be deemed to be severed from these Terms of Service, such determination shall not affect the validity and enforceability of any other remaining provisions.</p></br>
                    
                                <h4>SECTION 14. Termination</h4>
                                <p>The obligations and liabilities of the parties incurred prior to the termination date shall survive the termination of this agreement for all purposes.</p>
                                <p>These Terms of Service are effective unless and until terminated by either you or us. You may terminate these Terms of Service at any time by notifying us that you no longer wish to use our Services, or when you cease using our Site.</p>
                                <p>If in our sole judgment you fail, or we suspect that you have failed, to comply with any term or provision of these Terms of Service, we may also terminate this agreement at any time without notice and you will remain liable for all amounts due up to and including the date of termination; and/or accordingly may deny you access to our Services (or any part thereof).</p></br>
                    
                                <h4>SECTION 15. Entire Agreement </h4>
                                <p>Our failure to exercise or enforce any right or provision of these Terms of Service shall not constitute a waiver of such right or provision.</p>
                                <p>These Terms of Service and any policies or operating rules posted by us on this Site or in respect to the Service constitutes the entire agreement and understanding between you and us and govern your use of the Service, superseding any prior or contemporaneous agreements, communications and proposals, whether oral or written, between you and us (including, but not limited to, any prior versions of the Terms of Service).</p>
                                <p>Any ambiguities in the interpretation of these Terms of Service shall not be construed against the drafting party.</p></br>
                    
                                <h4>SECTION 16. Changes to the services </h4>
                                <p>We reserve the right to change or replace any part of these Terms at any time in our discretion. Any new features that are added to the current Site shall be subject to the Terms of Service. Prices for our Services may also be subject to change without notice.</p>
                                <p>If we make any changes, we will post updates regarding the modified Terms on our Site. Your continued use of the Site following the posting of any changes means acceptance of those changes. We shall not be liable to you or to any third-party for any modification, price change, or discontinuation of the Services or any part thereof.</p>
                                <p>You can review the most current version of this agreement at any time on this page. The date of last modification is stated at the beginning of these Terms.</p>
                                <p>It is your responsibility to check this page periodically for changes.</p></br>
                    
                                <h4>SECTION 17. Governing Law </h4>
                                <p>These Terms of Service and any separate agreements whereby we provide you Services shall be governed by and construed in accordance with the laws of the Republic of the Philippines.</p></br>
                    
                                <h4>SECTION 18. Contact Information </h4>
                                <p>Questions about the Terms of Service should be sent to us at <a href="mailto:pelikuloveofficial@gmail.com">pelikuloveofficial@gmail.com</a> or by mail using the details provided below:</p></br>
                            </div>
                        </div> 
                        <div class="form-group row m-3 d-flex justify-content-center">
                            <div class="col-md-6 text-center">
                                <button type="submit" id="signUp" class="btn btn-lg btn-primary m-3" disabled
                                data-toggle="tooltip" data-placement="left" title="Read Terms and Conditions First">
                                    {{ __('Sign Up') }}
                                </button>
                            </div>


                        </div>
                        <div class="row">
                            <div class="col-md-8 offset-md-2">
                                <div
                                    style="width: 100%; height: 20px; border-bottom: 1px solid #bbbbbb; text-align: center; margin-bottom: 25px;">
                                    <span
                                        style="font-size: 1em;  position: relative; top: .5em; background-color: white; padding: 0 10px;">
                                        or
                                    </span>
                                </div>

                                @include('partials.socials-icons')

                                <p class="text-center mb-4">
                                    Already have an account? <a href="{{ url('/login') }}">Log in</a>
                                </p>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('footer_scripts')
    @include('scripts.tooltips')

    @if(config('settings.reCaptchStatus'))
    <script src='https://www.google.com/recaptcha/api.js'></script>
    @endif

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous">
    </script>

    <script>
        $(document).ready(function() {
            // Passwords
            $("#form-show-password a").on('click', function(event) {
                event.preventDefault();
                if ($('#form-show-password input').attr("type") == "text") {
                    $('#form-show-password input').attr('type', 'password');
                    $('#form-show-password i').addClass("fa-eye-slash");
                    $('#form-show-password i').removeClass("fa-eye");
                } else if ($('#form-show-password input').attr("type") == "password") {
                    $('#form-show-password input').attr('type', 'text');
                    $('#form-show-password i').removeClass("fa-eye-slash");
                    $('#form-show-password i').addClass("fa-eye");
                }
            });

            // Sign Up btn Enable on Scroll Down
            document.getElementsByName("container_terms")[0].addEventListener("scroll", checkScrollHeight, false);

            var tosDiv = document.getElementsByName("container_terms")[0];
            var signUpBtn = document.getElementById("signUp");

            function checkScrollHeight() {                

                if(tosDiv.scrollTop >= (tosDiv.scrollHeight - tosDiv.offsetHeight)) {
                    signUpBtn.disabled = false;
                    // Remove tooltip on sign up enable
                    signUpBtn.title = '';
                }
            }          
        })
    </script>
@endsection