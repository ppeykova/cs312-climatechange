function addToBasket(id)
{
    var basketCookie = [];
    if(Cookies.get('basket') != undefined) {
        basketCookie = JSON.parse(Cookies.get('basket'));
    }

    basketCookie.push(id);
    Cookies.set('basket', JSON.stringify(basketCookie));
    alert("Product added to basket successfully!");

}

function checkUserLocation()
{
    var address = document.getElementById("userLocation").value;
    if(!address)
    {

        submitForm();

    } else {

        $.ajax(
            {
                url: 'https://api.opencagedata.com/geocode/v1/json',
                method: 'GET',
                data:
                    {
                        'key': '0bd6d81685ca456d862472ceadb767af',
                        'q': address,
                        'no_annotations': 1
                        // see other optional params:
                        // https://opencagedata.com/api#forward-opt
                    },
                dataType: 'json',
                statusCode:
                    {
                        200: function (response) {  // success
                            if (response.results.length === 0) {
                                console.log("Address could not be found");
                                document.getElementById("userLocationMessage").textContent = "Address could not be found";
                            } else {
                                console.log(response.results[0]['geometry']);
                                document.getElementById("userLatitude").setAttribute('value', response.results[0]['geometry']['lat']);
                                document.getElementById("userLongitude").setAttribute('value', response.results[0]['geometry']['lng']);
                                submitForm();
                            }
                        },
                        402: function () {
                            console.log('hit free-trial daily limit');
                            console.log('become a customer: https://opencagedata.com/pricing');
                        }
                        // other possible response codes:
                        // https://opencagedata.com/api#codes
                    }
            });
    }
}