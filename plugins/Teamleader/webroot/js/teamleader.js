$(document).ready(function () {
    $(".js-data-example-ajax").select2({
        ajax: {
            url: "http://test.maaike.test/Teamleader/getCompany",
            dataType: 'json',
            method: "POST",
            delay: 250,
            data: function (params) {
                return {
                    amount: 50,
                    pageno: 0,
                    api_group: 19153,
                    api_secret: "tOObNQn8zzU35allrmX1HLMBtagrXeGgSlhv1vurVekQfw2xJPohr1JK2P2PUzVCK3YBpiSbn3StqKQZp57GWGhOmau6zfy99mBpvkqId81tJIjYEgvrNC5ZDpV2vj2vwuKRE1qH0h1zQbokhJBUcxJFNvy9Frv1L6JfXZNO7EeOFsYN1qy4O8zstYsYgNPRJpXxeAcc",
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
