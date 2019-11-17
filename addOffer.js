function uploadImage(input)
{
    var reader;
    if (input.files && input.files[0])
    {
        reader = new FileReader();
        reader.onload = function (e) { document.getElementById("preview").setAttribute('src', e.target.result); }
        reader.readAsDataURL(input.files[0]);
    }
}

function validate()
{
    var valid = true;
    var category = document.getElementById("category");
    var retailPrice = document.getElementById("retailPrice");
    var offerPrice = document.getElementById("offerPrice");
    var description = document.getElementById("description");
    var addrStreet = document.getElementById("addrStreet");
    var addrCity = document.getElementById("addrCity");
    var addrPostcode = document.getElementById("addrPostcode");

    document.getElementById("categoryMessage").style.display = "none";
    document.getElementById("retailPriceMessage").style.display = "none";
    document.getElementById("offerPriceMessage").style.display = "none";
    document.getElementById("descriptionMessage1").style.display = "none";
    document.getElementById("descriptionMessage2").style.display = "none";
    document.getElementById("addrStreetMessage").style.display = "none";
    document.getElementById("addrCityMessage").style.display = "none";
    document.getElementById("addrPostcodeMessage").style.display = "none";

    if(category.options[category.selectedIndex].value == 0)
    {
        document.getElementById("categoryMessage").style.display = "inline";
        valid = false;
    }
    if(retailPrice.value == 0)
    {
        document.getElementById("retailPriceMessage").style.display = "inline";
        valid = false;
    }
    if(offerPrice.value == 0)
    {
        document.getElementById("offerPriceMessage").style.display = "inline";
        valid = false;
    }
    if(description.value == "")
    {
        document.getElementById("descriptionMessage1").style.display = "inline";
        valid = false;
    }
    if(description.value.length > 255)
    {
        document.getElementById("descriptionMessage2").style.display = "inline";
        valid = false;
    }
    if(addrStreet.value == "")
    {
        document.getElementById("addrStreetMessage").style.display = "inline";
        valid = false;
    }
    if(addrCity.value == "")
    {
        document.getElementById("addrCityMessage").style.display = "inline";
        valid = false;
    }
    if(addrPostcode.value == "")
    {
        document.getElementById("addrPostcodeMessage").style.display = "inline";
        valid = false;
    }
    return valid;
}