const elements = stripe.elements({
    clientSecret,
});
const cardElement = elements.create("payment");
const cardHolderName = document.getElementById("card-holder-name");
const cardButton = document.getElementById("card-button");
cardElement.mount("#payment-element");
cardButton.addEventListener("click", async (e) => {
    e.preventDefault();
    const { error } = await stripe.confirmPayment({
        elements,
        confirmParams: {
            return_url: returnUrl,
        },
        redirect: "if_required",
    });
    if (error) {
        alert(error.message);
    } else {
        document.getElementById("purchase-form").submit();
    }
});
