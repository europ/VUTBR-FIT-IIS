@extends('layouts.app')

@section('content')


    <div class="col-md-12">
        <div class="blank-slate-pf">
            <h1>
                ABOUT
            </h1>
                <button class="btn btn-default" data-toggle="modal" data-target="#about-modal">Copyright</button>
        </div>
    </div>

            <div class="modal fade" id="about-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content about-modal-pf">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                                <span class="pficon pficon-close"></span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <h1>{{config('app.name')}}</h1>
                                 <div class="trademark-pf">
                                <h3>&copy; 2017 Schauer Marek, Šuhaj Peter, Tóth Adrián</h2>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <img src="/img/logo-alt.svg" alt="Patternfly Symbol">
                        </div>
                    </div>
                </div>
            </div>


@endsection

@section('scripts')

@endsection