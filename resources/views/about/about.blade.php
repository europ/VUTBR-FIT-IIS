@extends('layouts.app')

@section('content')


    <div class="col-md-12">
        <div class="blank-slate-pf">
            <h1>
                <strong>ABOUT</strong>
            </h1>
            <p>
                <br> <!-- HACK -->
                Tento projekt bol vytvorený pre predmet "Informační systémy".
            </p>
            <p>
                Cieľom projektu bolo vytvoriť plne fungujúci informačný systém s webovým rozhraním. Návrh<br>
                projektu sa zakladal na návrhu vytvoreného v rámci predmetu "Databázové systémy", podľa<br>
                zvoleného zadania z predmetu "Úvod do softwarového inženýrství".
                <br><br> <!-- HACK -->
            </p>
            <button class="btn btn-info" data-toggle="modal" data-target="#about-modal">Copyright</button>
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
                            <h1>
                                <strong>{{config('app.name')}}</strong>
                                <br><br> <!-- HACK -->
                            </h1>
                            <table class="table text-center">
                                <tbody>
                                    <tr>
                                        <td><strong>Schauer</strong></td>
                                        <td>Marek</td>
                                        <td><a class="text-right" href="mailto:xschau00@stud.fit.vutbr.cz">xschau00@stud.fit.vutbr.cz</a></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Šuhaj</strong></td>
                                        <td>Peter</td>
                                        <td><a class="text-right" href="mailto:xsuahj02@stud.fit.vutbr.cz">xsuahj02@stud.fit.vutbr.cz</a></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Tóth</strong></td>
                                        <td>Adrián</td>
                                        <td><a class="text-right" href="mailto:xtotha01@stud.fit.vutbr.cz">xtotha01@stud.fit.vutbr.cz</a></td>
                                    </tr>
                                    <tr><td></td><td></td><td></td></tr> <!-- HACK -->
                                </tbody>
                            </table>
                            <div class="trademark-pf">
                                <h3><br>&copy; 2017 Schauer Marek, Šuhaj Peter, Tóth Adrián</h3>
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
