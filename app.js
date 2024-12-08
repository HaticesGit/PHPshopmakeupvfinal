document.querySelector("#btnAddReview").addEventListener("click", function() {
    //productid
    //comment text;
    let productId = this.dataset.productid;
    let text = document.querySelector("#reviewText").value;

    console.log(productId);
    console.log(text);
    //posten naar databank (ajax)
    let formData = new FormData();

    formData.append('product_id', productId);
    formData.append('text', text);

    fetch('ajax/saveReview.php', {
        method: 'POST',
        body: formData
    })
    .then((response) => response.json())
    .then((result) => {
        let newReview = document.createElement('li');
        newReview.innerHTML = result.body;
        document.querySelector(".reviewLI").appendChild(newReview);
    })
    .catch((error) => {
        console.error('Error:', error);
    });



    //antwoord ok? toon comment onderaan
});