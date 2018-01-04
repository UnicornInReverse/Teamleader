$(document).ready(function () {
    console.log(window.location.hostname);
    $(".js-data-example-ajax").select2({
        ajax: {
            url: "http://" + window.location.hostname + "/teamleader/teamleader/get-company",
            dataType: 'json',
            method: "POST",
            delay: 250,
            data: function (params) {
                return {
                    amount: 50,
                    pageno: 0,
                    searchby: params.term // search term
                };
            },
            processResults: function (data, params) {
                // parse the results into the format expected by Select2
                // since we are using custom formatting functions we do not need to
                // alter the remote JSON data, except to indicate that infinite
                // scrolling can be used
                params.page = params.page || 1;

                return {
                    results: data,
                    pagination: {
                        more: (params.page * 30) < data.total_count
                    }
                };
            },
            cache: true
        },
        placeholder: 'Zoek klant...',
        escapeMarkup: function (markup) {
            return markup;
        }, // let our custom formatter work
        minimumInputLength: 1,
        templateResult: formatCompany,
        templateSelection: formatCompanySelection
    });

    function formatCompany(company) {
        if (company.loading) {
            return company.text;
        }

        return "<div class='select2-result-repository clearfix'>" +
            "<div class='form-control input-md'>"+ company.name +"</div>"
    }

    function formatCompanySelection(company) {
        return company.name || company.text;
    }

});
