let table = new DataTable('#table-data', {
    "order": [[8, 'desc']],
    "columnDefs": [
        {"className": "dt-center", "targets": "_all"} //all text in columns align center
    ],
    "dom": "<'row mb-3'<'col-6 col-md-4'l><'col-6 col-md-4 'B><'col-6 col-md-4 col-sm-12'f>>" +
        "<'row my-4'<'col-sm-12'tr>>" +
        "<'row mb-3'<'col-6 col-md-4 col-sm-12'i><'col-6 col-md-4 m-0'><'d-flex justify-content-end col-6 col-md-4 col-sm-12'p>>",
    buttons: [
        {
            extend: 'excel',
            className: 'btn btn-success',
            exportOptions: {
                columns: 'th:not(:last-child)'
            }
        },
        {
            extend: 'pdf',
            className: 'btn btn-success',
            exportOptions: {
                columns: 'th:not(:last-child)'
            }
        }
    ]
});
