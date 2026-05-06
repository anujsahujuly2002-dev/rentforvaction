function getStates(id) {
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });
    $.ajax({
        url: site_url + "/admin/destination/get-state-by-country-id",
        type: "POST",
        data: { id: id },
        // contentType: false,
        cache: false,
        // processData:false,
        success: (res) => {
            if (res.status == 200) {
                $("#state_name").html("");
                let html = `<option value="">Select State</option>`;
                $.each(res.state, function (key, value) {
                    html += `<option value="${
                        value.id
                    }">${capitalizeFirstLetter(value.name)}</option>`;
                });
                $("#state_name").append(html);
            } else {
                $("#state_name").html("");
            }
        },
    });
}

function capitalizeFirstLetter(string) {
    return string.charAt(0).toUpperCase() + string.slice(1);
}

function getRegion(id) {
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });
    $.ajax({
        url: site_url + "/admin/destination/get-region-by-state-id",
        type: "POST",
        data: { id: id },
        // contentType: false,
        cache: false,
        // processData:false,
        success: (res) => {
            let html = `<option value="">Select region</option>`;
            if (res.status == 200) {
                $("#region_name").html("");
                $.each(res.region, function (key, value) {
                    html += `<option value="${
                        value.id
                    }">${capitalizeFirstLetter(value.name)}</option>`;
                });
                $("#region_name").append(html);
            } else {
                $("#region_name").html("");
                $("#region_name").append(html);
            }
        },
    });
}

function getCity(id) {
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });
    $.ajax({
        url: site_url + "/admin/destination/get-city-by-region-id",
        type: "POST",
        data: { id: id },
        // contentType: false,
        cache: false,
        // processData:false,
        success: (res) => {
            if (res.status == 200) {
                $("#city_name").html("");
                let html = `<option value="">Select City</option>`;
                $.each(res.city, function (key, value) {
                    html += `<option value="${
                        value.id
                    }">${capitalizeFirstLetter(value.name)}</option>`;
                });
                $("#city_name").append(html);
            } else {
                $("#city_name").html("").append(html);
            }
        },
    });
}

function getSubCity(id) {
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });
    $.ajax({
        url: site_url + "/admin/destination/get-sub-city-by-city-id",
        type: "POST",
        data: { id: id },
        // contentType: false,
        cache: false,
        // processData:false,
        success: (res) => {
            if (res.status == 200) {
                $("#sub_city_name").html("");
                let html = `<option value="">Select Sub City</option>`;
                $.each(res.subCity, function (key, value) {
                    html += `<option value="${
                        value.id
                    }">${capitalizeFirstLetter(value.name)}</option>`;
                });
                $("#sub_city_name").append(html);
            } else {
                $("#sub_city_name").html("");
                let html = `<option value="">Select Sub City</option>`;
                $("#sub_city_name").append(html);
            }
        },
    });
}
