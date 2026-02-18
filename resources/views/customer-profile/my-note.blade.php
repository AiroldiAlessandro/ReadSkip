@extends('layouts.standardpage')
@section('content')
    <h1 class="text-5xl font-bold text-center text-black">
        Le mie Evidenziazioni
    </h1>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-2">
                <table id="highlightsTable" class="display" style="width:100%">
                    <thead>
                        <tr>
                            <th>Titolo</th>
                            <th>Capitolo</th>
                            <th>Testo</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($highlights as $h)
                            <tr>
                                <td>{{ $h['book_title']}}  <a href="https://readskip.com/read/{{$h['book_id']}}?chapter={{$h['chapter']}}">Vai</a> </td>
                                <td>{{ $h['chapter_title'] }}</td>
                                <td>{{ $h['text'] }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <style>
        #dt-length-0{
            width: 70px;
        }
    </style>
    <script>
        $(document).ready(function () {
            let table = $('#highlightsTable').DataTable({
                pageLength: 10,
                language: {
                    url: "//cdn.datatables.net/plug-ins/2.1.3/i18n/it-IT.json"
                }
            });
            $('#highlightsTable tbody').on('click', 'tr', function () {
                window.location.href =  $(this).children('td').children('a').attr('href');
            });
        });
    </script>
@endsection
