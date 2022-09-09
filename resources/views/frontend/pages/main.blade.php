@extends('frontend.layouts.master')

@section('container')
    <section class="panel-right-area">
        <div class="panel-detail-area">
            <div class="pannel-detail-heading">
                <h1>Test Results</h1>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor</p>
            </div>
            <div class="panel-inner-detail">
                <table>
                    <tr>
                        <th width="30">#</th>
                        <th>Due Date</th>
                        <th>Difficulty</th>
                        <th>Percentage</th>
                        <th>Status</th>
                    </tr>
                    <tr>
                        <td>1</td>
                        <td>26/7/2022</td>
                        <td><span class="easy">easy</span></td>
                        <td>75%</td>
                        <td><span class="passed">passed</span></td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>26/7/2022</td>
                        <td><span class="intermediate">intermediate</span></td>
                        <td>32%</td>
                        <td><span class="failed">failed</span></td>
                    </tr>
                    <tr>
                        <td>3</td>
                        <td>26/7/2022</td>
                        <td><span class="advance">advance</span></td>
                        <td>--</td>
                        <td><span class="pending">pending</span></td>
                    </tr>
                </table>
            </div>
        </div>
    </section>
@endsection