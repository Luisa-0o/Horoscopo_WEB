{{-- Incluir en las páginas que usan DataTables. Uso: @include('partials.datatables', ['tabla' => '#miTabla']) --}}
@push('estilos')
    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.8/css/dataTables.bootstrap5.min.css">
@endpush

@push('scripts')
    <script src="https://cdn.datatables.net/2.1.8/js/dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/2.1.8/js/dataTables.bootstrap5.min.js"></script>
    <script>
        $(function () {
            new DataTable('{{ $tabla }}', {
                pageLength: 10,
                language: {
                    search: 'Buscar:',
                    lengthMenu: 'Mostrar _MENU_ registros',
                    info: 'Mostrando _START_ a _END_ de _TOTAL_ registros',
                    infoEmpty: 'No hay registros',
                    infoFiltered: '(filtrado de _MAX_ registros)',
                    zeroRecords: 'No se encontraron resultados',
                    emptyTable: 'No hay datos todavía',
                    paginate: { first: 'Primero', last: 'Último', next: 'Siguiente', previous: 'Anterior' }
                }
            });
        });
    </script>
@endpush
