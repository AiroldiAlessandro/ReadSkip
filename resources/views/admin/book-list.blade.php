<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Libri') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-2">
                <table id="booksTable" class="display" style="width:100%">
                    <thead>
                        <tr>
                            <th>Titolo</th>
                            <th>Autore</th>
                            <th>Creato il</th>
                            <th>Stato</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            let table = $('#booksTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{{ route("admin.booklist-data") }}',
                    type: 'POST',
                    data: {_token: '{{ csrf_token() }}'} // per protezione CSRF
                },
                columns: [
                    { data: 'title' },
                    { data: 'author' },
                    { data: 'created_at' },
                    { 
                        data: 'status',
                        render: function(data, type, row) {
                            return data == 1 ? 'Pubblicato' : 'Bozza';
                        }
                    }
                ],
                rowId: 'id',
                order: [[2, 'desc']]
            });
            $('#booksTable tbody').on('click', 'tr', function () {
                let data = table.row(this).data();
                if (data) {
                    window.location.href = '/admin/bookdetail/' + data.id;
                }
            });
        });
        $('#booksTable').on('draw.dt', function () {
            $('#booksTable tbody tr').addClass('hover:bg-gray-100 cursor-pointer');
        });

    </script>
</x-app-layout>
