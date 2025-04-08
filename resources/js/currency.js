document.addEventListener("DOMContentLoaded", function () {
    const currencyList = {
        USD: "USD - US Dollar",
        MYR: "MYR - Malaysian Ringgit",
        EUR: "EUR - Euro",
        GBP: "GBP - British Pound",
        JPY: "JPY - Japanese Yen",
        CNY: "CNY - Chinese Yuan",
    };

    const select = document.getElementById("preferred_currency");
    const selected = window.selectedCurrency;

    Object.entries(currencyList).forEach(([code, label]) => {
        const option = document.createElement("option");
        option.value = code;
        option.textContent = label;
        if (code === selected) {
            option.selected = true;
        }
        select.appendChild(option);
    });
});
