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
    var addrArea = document.getElementById("addrArea");

    document.getElementById("imageMessage").textContent = "*";
    document.getElementById("categoryMessage").textContent = "*";
    document.getElementById("retailPriceMessage").textContent = "*";
    document.getElementById("offerPriceMessage").textContent = "*";
    document.getElementById("descriptionMessage").textContent = "*";
    document.getElementById("addrStreetMessage").textContent = "*";
    document.getElementById("addrCityMessage").textContent = "*";
    document.getElementById("addrPostcodeMessage").textContent = "*";
    document.getElementById("addrAreaMessage").textContent = "*";


    if(image.value == 0)
    {
        document.getElementById("imageMessage").textContent = "* No category selected";
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
    if(addrArea.value == 0)
    {
        document.getElementById("addrAreaMessage").textContent = "* Area is required";
        valid = false;
    }
    if(valid)
        submitForm();
}