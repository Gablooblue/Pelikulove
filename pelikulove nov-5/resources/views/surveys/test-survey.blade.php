@extends('layouts.app')
		
@section('template_title')
    PELIKULOVE | {{$course->title}} Stats
@endsection

@section('template_fastload_css')
@endsection

@section('content')
	
   <div class="container">  
   		<div class="row">
            <div class="col-sm-12">
                <div class="card">

                    <div class="card-header">
                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            <h3 id="card_title">
								<strong>
									{{$survey->title}}
								</strong>
                            </h3>		
                            <p>
                                {{$survey->intro}}
                            </p>		
                        </div>
					</div>

                    <form method="post" action="{{ route('survey.store')}}">
                        {{ csrf_field() }}
                        <input type="hidden" name="survey_id" value="{{$survey->id}}">
                    
						<div class="card-body">
							@foreach ($s_questions as $question)
								@php
									$name = 'question-' . $question->id;
								@endphp
								
								<h4>
									{{ $loop->iteration }}. {{ $question->title }}
								</h4>

								@switch($question->type)
									@case("identify")
										{{-- {!! Form::text($name, NULL, array('id' => $name, $question->necessity)) !!} --}}
										<input class="form-control" type="text" id="{{$name}}" name="{{$name}}" {{$question->necessity}}>
										@break
									@case("tf")										
										<div class="row justify-content-center">
											{{-- {!! Form::radio($name, NULL, array('name' => $name, 'value' => 'true', $question->necessity)) !!}											
											{!! Form::label($name, trans('forms.create_user_label_pw_confirmation'), array('class' => 'col-md-3 control-label')); !!} --}}
											<input class="form-check-input" type="radio" name="{{$name}}" value="true" {{$question->necessity}}>
											<label for="true">True</label>
											<input class="form-check-input" type="radio" name="{{$name}}" value="false">
											<label for="false">False</label>
										</div>
										@break
									@case("multi")
										<div class="row justify-content-center">
											@php
												$correctAnswer = $question->answer;
												$dummyAnswersCsv = $question->dummy_answers;
												$dummyAnswersArray = explode(",",$dummyAnswersCsv)
												$dummyAnswers = collect($dummyAnswersArray);
												$allAnswers->push($correctAnswer);
												$allAnswers->shuffle();
											@endphp
											@foreach ($allAnswers as $answer)
												<input class="form-check-input" type="radio" name="{{$name}}" value="{{$answer}}" {{$question->necessity}}>
												<label for="{{$answer}}">{{$answer}}</label>		
											@endforeach									
										</div>
										@break
									@case("text")
										<input class="form-control" type="textarea" id="{{$name}}" name="{{$name}}" {{$question->necessity}}>
										@break
									@case("rating-15")
										<div class="row justify-content-center">
											<input class="form-check-input" type="radio" name="{{$name}}" value="1" {{$question->necessity}}>
											<label for="true">1</label>
											<input class="form-check-input" type="radio" name="{{$name}}" value="2">
											<label for="false">2</label>
											<input class="form-check-input" type="radio" name="{{$name}}" value="3" {{$question->necessity}}>
											<label for="true">3</label>
											<input class="form-check-input" type="radio" name="{{$name}}" value="4">
											<label for="false">4</label>
											<input class="form-check-input" type="radio" name="{{$name}}" value="5">
											<label for="false">5</label>
										</div>
										@break
									@default
										Question type "{{ $question->type }}" not defined.
								@endswitch

								<br>
							@endforeach                		
						</div>   	
						
					</form>	

				</div>
			</div><!--card-->     
        </div>	<!-- row -->	 
    </div><!-- container -->

@endsection

@section('footer_scripts')
@endsection
