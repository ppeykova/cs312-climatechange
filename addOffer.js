function uploadImage(input)
{
    var reader;
    if (input.files && input.files[0])
    {
        var preview = document.getElementById("preview");
        reader = new FileReader();
        reader.onload = function (e) { preview.setAttribute('src', e.target.result); }
        reader.readAsDataURL(input.files[0]);
        preview.style.display = "inline";
    }
}

function validate()
{
    var valid = true;
    var image = document.getElementById("image");
    var category = document.getElementById("category");
    var retailPrice = document.getElementById("retailPrice");
    var offerPrice = document.getElementById("offerPrice");
    var description = document.getElementById("description");
    var addrStreet = document.getElementById("addrStreet");
    var addrCity = document.getElementById("addrCity");
    var addrPostcode = document.getElementById("addrPostcode");

    document.getElementById("imageMessage").textContent = "*";
    document.getElementById("categoryMessage").textContent = "*";
    document.getElementById("retailPriceMessage").textContent = "*";
    document.getElementById("offerPriceMessage").textContent = "*";
    document.getElementById("descriptionMessage").textContent = "*";
    document.getElementById("addrStreetMessage").textContent = "*";
    document.getElementById("addrCityMessage").textContent = "*";
    document.getElementById("addrPostcodeMessage").textContent = "*";

    if(image.value == 0)
    {
        document.getElementById("imageMessage").textContent = "* No image selected";
        valid = false;
    }
    if(category.options[category.selectedIndex].value == 0)
    {
        document.getElementById("categoryMessage").textContent = "* No category selected";
        valid = false;
    }
    else if(offerPrice.value > maxPrices[category.selectedIndex - 1])
    {
        document.getElementById("offerPriceMessage").textContent = "* Offer price is too high for the selected category (Max price: £" + maxPrices[category.selectedIndex - 1] + ")";
        valid = false;
    }

    if(retailPrice.value == 0)
    {
        document.getElementById("retailPriceMessage").textContent = "* Retail price is required";
        valid = false;
    }
    if(offerPrice.value == 0)
    {
        document.getElementById("offerPriceMessage").textContent = "* Offer price is required";
        valid = false;
    }
    if(description.value == "")
    {
        document.getElementById("descriptionMessage").textContent = "* Description is required";
        valid = false;
    }
    if(description.value.length > 255)
    {
        document.getElementById("descriptionMessage").textContent = "* Description must be less than 255 characters";
        valid = false;
    }
    if(addrStreet.value == "")
    {
        document.getElementById("addrStreetMessage").textContent = "* Street address is required";
        valid = false;
    }
    if(addrCity.value == "")
    {
        document.getElementById("addrCityMessage").textContent = "* City is required";
        valid = false;
    }
    if(addrPostcode.value == "")
    {
        document.getElementById("addrPostcodeMessage").textContent = "* Postcode is required";
        valid = false;
    }
    if(valid)
    {
        var address = addrStreet.value + ", " + addrCity.value + ", " + addrPostcode.value;
        //console.log(address);
        geocode(address);
    }
}

function geocode(query)
{
    $.ajax(
    {
        url: 'https://api.opencagedata.com/geocode/v1/json',
        method: 'GET',
        data:
            {
            'key': '0bd6d81685ca456d862472ceadb767af',
            'q': query,
            'no_annotations': 1
            // see other optional params:
            // https://opencagedata.com/api#forward-opt
        },
        dataType: 'json',
        statusCode:
            {
            200: function(response)
            {  // success
                if(response.results.length === 0)
                {
                    console.log("Address could not be found");
                    document.getElementById("addrStreetMessage").textContent = "* Address could not be found";
                }
                else
                {
                    console.log(response.results[0]['geometry']);
                    document.getElementById("geocodeLatitude").setAttribute('value', response.results[0]['geometry']['lat']);
                    document.getElementById("geocodeLongitude").setAttribute('value', response.results[0]['geometry']['lng']);
                    submitForm();
                }
            },
            402: function()
            {
                console.log('hit free-trial daily limit');
                console.log('become a customer: https://opencagedata.com/pricing');
            }
            // other possible response codes:
            // https://opencagedata.com/api#codes
        }
    });
}