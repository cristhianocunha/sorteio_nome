$(document).ready(function () {
    const sortearNomeButton = $('#sortearNome');
    const nomeSorteadoElement = $('#nomeSorteado');

    // Carrega o arquivo JSON
    $.getJSON('lista_nome2.json', function (data) {
        const nomes = data.nomes;

        sortearNomeButton.click(function () {
            const indicator = document.querySelector(".indicator");
            const output = document.querySelector("output");

            var percent = 0;
            var interval;

            interval = setInterval(function () {
                percent++;
                output.value = percent + "%";
                indicator.setAttribute("style", `--completion: ${percent}%`);

                if (percent == 100) {
                    clearInterval(interval);
                    const nomeSorteado = sortearNomeAleatorio(nomes);
                    nomeSorteadoElement.text(`Nome Sorteado: ${nomeSorteado}`);
                }
            }, 30);

        });
    }).fail(function (error) {
        console.error('Erro ao carregar o arquivo JSON:', error);
    });

    function sortearNomeAleatorio(nomes) {
        const indiceSorteado = Math.floor(Math.random() * nomes.length);
        return nomes[indiceSorteado];
    }
});
