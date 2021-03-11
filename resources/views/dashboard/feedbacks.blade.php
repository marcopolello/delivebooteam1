@extends('layouts.layout-dashboard')

@section('feedbacks')

            @if (!empty($feedbacksOrder))
                <div class="card-2">
                    @foreach ($feedbacksOrder as $fb)
                        
                        <div class="mini-card">
                            <h4>{{$fb -> name}}</h4>
                            <h5>{{$fb -> email}}</h5>
                            <h1>{{$fb -> rate}}</h1>
                            <p>{{$fb -> comment}}</p>
                        </div>

                    @endforeach
                </div>
            @else
                <div class="card-2">
                    <div class="mini-card">
                        <h4>Al momento non ci sono feedback</h4>
                    </div>
                </div>
            @endif

            {{-- CONTAINER PRINCIPALE DELLE CARD --}}
                {{-- CARD ORDER--}}
                <div class="card-2">
                    @foreach ($feedbacksOrder as $fb)
                        
                        <div class="mini-card">
                            <h4>{{$fb -> name}}</h4>
                            <h5>{{$fb -> email}}</h5>
                            <h1>{{$fb -> rate}}</h1>
                            <p>{{$fb -> comment}}</p>
                        </div>

                    @endforeach
                </div>

@endsection