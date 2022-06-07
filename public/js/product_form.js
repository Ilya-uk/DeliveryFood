let
    discount = document.querySelector('#discount'),
    oldPrice = document.querySelector('#old_price');

discount.onclick = oldPriceChange;

function oldPriceChange() {
    if (discount.checked) {
        oldPrice.disabled = false;
    } else {
        oldPrice.disabled = true;
    }

}


