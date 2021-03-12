@extends('layouts.layout-dashboard')

@section('feedbacks')


<div class="new-feed">
    
    @foreach ($feedbacksOrder as $fb)
        <div class="feed-bubble">
            <h4>
                {{ $fb -> name }}
            </h4>
            <h6>
                {{ $fb -> email }}
            </h6>
            <p>
                {{ $fb -> comment }}
            </p>

            <div>
                @if ($fb -> rate > 0)
                @for ($i=0; $i < $fb -> rate; $i++)
                  <i class="fas fa-star"></i>
                @endfor
                @endif
                @if (5 - $fb -> rate > 0)
                    @for ($i=0; $i < (5 - $fb -> rate ); $i++)
                        <i class="far fa-star"></i>
                    @endfor
                @endif
            </div>

    </div>
    @endforeach

</div>

@endsection