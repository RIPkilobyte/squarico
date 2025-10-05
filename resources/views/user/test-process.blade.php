@extends('user')
@section('right-content')

    <div class="p-lg-5 text-center">
        <h2>Investor appropriateness test</h2>
        <form action="{{ route('test') }}" method="post">
            @csrf
            <nav class="d-none">
                <div class="" id="nav-tab" role="tablist">
                    <button class="" id="nav-tab1" data-bs-toggle="tab" data-bs-target="#nav1" type="button" role="tab" aria-controls="nav1"></button>
                    <button class="" id="nav-tab2" data-bs-toggle="tab" data-bs-target="#nav2" type="button" role="tab" aria-controls="nav2"></button>
                    <button class="" id="nav-tab3" data-bs-toggle="tab" data-bs-target="#nav3" type="button" role="tab" aria-controls="nav3"></button>
                    <button class="" id="nav-tab4" data-bs-toggle="tab" data-bs-target="#nav4" type="button" role="tab" aria-controls="nav4"></button>
                    <button class="" id="nav-tab5" data-bs-toggle="tab" data-bs-target="#nav5" type="button" role="tab" aria-controls="nav5"></button>
                    <button class="" id="nav-tab6" data-bs-toggle="tab" data-bs-target="#nav6" type="button" role="tab" aria-controls="nav6"></button>
                    <button class="" id="nav-tab7" data-bs-toggle="tab" data-bs-target="#nav7" type="button" role="tab" aria-controls="nav7"></button>
                    <button class="" id="nav-tab8" data-bs-toggle="tab" data-bs-target="#nav8" type="button" role="tab" aria-controls="nav8"></button>
                </div>
            </nav>

            <?php
            $testDatas = array(
                '1' => array(
                    'progress' => '11',
                    'submit' => 'Next',
                    'question' => 'Do you understand that past investment performance is not a guide to future performance?',
                    'answer-1' => 'Yes',
                    'answer-2' => 'No',
                    'answer-3' => 'The investment is fixed and guaranteed'
                ),
                '2' => array(
                    'progress' => '22',
                    'submit' => 'Next',
                    'question' => 'Do you understand the level of risk associated with this investment?',
                    'answer-1' => 'Yes',
                    'answer-2' => 'No',
                    'answer-3' => 'There is no risk'
                ),
                '3' => array(
                    'progress' => '33',
                    'submit' => 'Next',
                    'question' => 'Do you understand that you will not receive any advice from us?',
                    'answer-1' => 'Yes',
                    'answer-2' => 'No',
                    'answer-3' => 'I believe I will if I ask for it'
                ),
                '4' => array(
                    'progress' => '44',
                    'submit' => 'Next',
                    'question' => 'Do you understand the complexities of property investment?',
                    'answer-1' => 'Yes',
                    'answer-2' => 'No',
                    'answer-3' => "I'm not sure"
                ),
                '5' => array(
                    'progress' => '55',
                    'submit' => 'Next',
                    'question' => 'Have you read our terms and conditions carefully and understood them?',
                    'answer-1' => 'Yes',
                    'answer-2' => 'No',
                    'answer-3' => "I don’t need to"
                ),
                '6' => array(
                    'progress' => '66',
                    'submit' => 'Next',
                    'question' => 'Are projected level of returns guaranteed?',
                    'answer-1' => 'No, returns may be less than originally projected.',
                    'answer-2' => 'Yes, the projected returns for investments promoted on this platform are guaranteed by SQuarico.',
                    'answer-3' => 'Yes, the returns are guaranteed by the UK Financial Conduct Authority (FCA).'
                ),
                '7' => array(
                    'progress' => '77',
                    'submit' => 'Next',
                    'question' => 'Will you be able to get your money out whenever you want?',
                    'answer-1' => 'No, it could be difficult to sell my investment in a timely fashion, or indeed at all.',
                    'answer-2' => 'Yes, if I give written notice, SQuarico will repay my investment whenever I want.',
                    'answer-3' => 'Yes, I will be able to sell my shares via any stockbroker.'
                ),
                '8' => array(
                    'progress' => '88',
                    'submit' => 'Finish',
                    'question' => 'Is your investment covered by the Financial Services Compensation Scheme (FSCS)?',
                    'answer-1' => 'No, if the investment fails any losses will not be covered by the FSCS. ',
                    'answer-2' => 'Yes, if I lose money on this investment, I can make a claim to the FSCS.',
                    'answer-3' => ''
                ),

            )
            ?>

            <div class="tab-content" id="nav-tabContent">

                @foreach($testDatas as $key => $testData)
                    <div class="tab-pane fade" id="nav{{ $key }}" role="tabpanel" aria-labelledby="nav-tab{{ $key }}">
                        <div class="progress my-4">
                            <div class="progress-bar bg-blueLight" role="progressbar" style="width: {{ $testData['progress'] }}%" aria-valuenow="{{ $testData['progress'] }}" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                        <p class="mb-4 fw-bold">{{ $testData['question'] }}</p>
                        <div class="test__answer"><input type="radio" name="question{{ $key }}[]" id="question{{ $key }}-1" value="{{ $testData['answer-1'] }}" />{{ $testData['answer-1'] }}</div>
                        <div class="test__answer"><input type="radio" name="question{{ $key }}[]" id="question{{ $key }}-2" value="{{ $testData['answer-2'] }}" />{{ $testData['answer-2'] }}</div>
                        @if($testData['answer-3'])
                            <div class="test__answer"><input type="radio" name="question{{ $key }}[]" id="question{{ $key }}-3" value="{{ $testData['answer-3'] }}" />{{ $testData['answer-3'] }}</div>
                        @endif
                        @if($testData['submit'] == 'Next')
                            <a class="w-100 btn btn-theme btn-blue" href="#" onclick="goTo({{ $key+1 }})">Next</a>
                        @else
                            <button class="w-100 btn btn-theme btn-blue" type="submit">Finish test</button>
                        @endif
                    </div>
                @endforeach

                <? /*
                <div class="tab-pane fade" id="nav1" role="tabpanel" aria-labelledby="nav-tab1">
                    <div class="progress my-4">
                        <div class="progress-bar progress-theme" role="progressbar" style="width: 11%" aria-valuenow="11" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    <p class="mb-4 fw-bold">Do you understand that past investment performance is not a guide to future performance?</p>
                    <div class="test__answer"><input type="radio" name="question1[]" id="question1-1" value="Yes" />Yes</div>
                    <div class="test__answer"><input type="radio" name="question1[]" id="question1-2" value="No" />No</div>
                    <div class="test__answer"><input type="radio" name="question1[]" id="question1-3" value="The investment is fixed and guaranteed" />The investment is fixed and guaranteed</div>
                    <a class="w-100 btn btn-lg btn-blue" href="#" onclick="goTo(2)">Next</a>
                </div>

                <div class="tab-pane fade" id="nav2" role="tabpanel" aria-labelledby="nav-tab2">
                    <h3>Do you understand the level of risk associated with this investment?</h3>
                    <label><input type="radio" name="question2[]" id="question2-1" value="Yes" />Yes</label>
                    <label><input type="radio" name="question2[]" id="question2-2" value="No" />No</label>
                    <label><input type="radio" name="question2[]" id="question2-3" value="There is no risk" />There is no risk</label>
                    <a href="#" onclick="goTo(3)">Answer</a>
                </div>
                <div class="tab-pane fade" id="nav3" role="tabpanel" aria-labelledby="nav-tab3">
                    <h3>Do you understand that you will not receive any advice from us?</h3>
                    <label><input type="radio" name="question3[]" id="question3-1" value="Yes" />Yes</label>
                    <label><input type="radio" name="question3[]" id="question3-2" value="No" />No</label>
                    <label><input type="radio" name="question3[]" id="question3-3" value="I believe I will if I ask for it" />I believe I will if I ask for it</label>
                    <a href="#" onclick="goTo(4)">Answer</a>
                </div>
                <div class="tab-pane fade" id="nav4" role="tabpanel" aria-labelledby="nav-tab4">
                    <h3>Do you understand the complexities of property investment?</h3>
                    <label><input type="radio" name="question4[]" id="question4-1" value="Yes" />Yes</label>
                    <label><input type="radio" name="question4[]" id="question4-1" value="No" />No</label>
                    <label><input type="radio" name="question4[]" id="question4-1" value="I'm not sure" />I'm not sure</label>
                    <a href="#" onclick="goTo(5)">Answer</a>
                </div>
                <div class="tab-pane fade" id="nav5" role="tabpanel" aria-labelledby="nav-tab5">
                    <h3>Have you read our terms and conditions carefully and understood them?</h3>
                    <label><input type="radio" name="question5[]" id="question5-1" value="Yes" />Yes</label>
                    <label><input type="radio" name="question5[]" id="question5-1" value="No" />No</label>
                    <label><input type="radio" name="question5[]" id="question5-1" value="I don’t need to" />I don’t need to</label>
                    <a href="#" onclick="goTo(6)">Answer</a>
                </div>
                <div class="tab-pane fade" id="nav6" role="tabpanel" aria-labelledby="nav-tab6">
                    <h3>Are projected level of returns guaranteed?</h3>
                    <label><input type="radio" name="question6[]" id="question6-1" value="No, returns may be less than originally projected." />No, returns may be less than originally projected.</label>
                    <label><input type="radio" name="question6[]" id="question6-1" value="Yes, the projected returns for investments promoted on this platform are guaranteed by SQuarico." />Yes, the projected returns for investments promoted on this platform are guaranteed by SQuarico.</label>
                    <label><input type="radio" name="question6[]" id="question6-1" value="Yes, the returns are guaranteed by the UK Financial Conduct Authority (FCA)." />Yes, the returns are guaranteed by the UK Financial Conduct Authority (FCA).</label>
                    <a href="#" onclick="goTo(7)">Answer</a>
                </div>
                <div class="tab-pane fade" id="nav7" role="tabpanel" aria-labelledby="nav-tab7">
                    <h3>Will you be able to get your money out whenever you want?</h3>
                    <label><input type="radio" name="question7[]" id="question7-1" value="No, it could be difficult to sell my investment in a timely fashion, or indeed at all." />No, it could be difficult to sell my investment in a timely fashion, or indeed at all.</label>
                    <label><input type="radio" name="question7[]" id="question7-1" value="Yes, if I give written notice, SQuarico will repay my investment whenever I want." />Yes, if I give written notice, SQuarico will repay my investment whenever I want.</label>
                    <label><input type="radio" name="question7[]" id="question7-1" value="Yes, I will be able to sell my shares via any stockbroker." />Yes, I will be able to sell my shares via any stockbroker.</label>
                    <a href="#" onclick="goTo(8)">Answer</a>
                </div>
                <div class="tab-pane fade" id="nav8" role="tabpanel" aria-labelledby="nav-tab8">
                    <h3>Is your investment covered by the Financial Services Compensation Scheme (FSCS)?</h3>
                    <label><input type="radio" name="question8[]" id="question8-1" value="No, if the investment fails any losses will not be covered by the FSCS." />No, if the investment fails any losses will not be covered by the FSCS.</label>
                    <label><input type="radio" name="question8[]" id="question8-1" value="Yes, if I lose money on this investment, I can make a claim to the FSCS." />Yes, if I lose money on this investment, I can make a claim to the FSCS.</label>
                    <button class="w-100 btn btn-lg btn-primary" type="submit">Submit</button>
                </div>
                */ ?>
            </div>
        </form>
    </div>

@push('scripts')
<script>
    function goTo(step) {
        $("#nav-tab"+step).click();
    }
$().ready(function(){
    $("#nav-tab1").click();
});
</script>
@endpush

@endsection
