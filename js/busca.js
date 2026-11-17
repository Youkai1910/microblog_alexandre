'use strict';

(() => {
    const form = document.getElementById('form-busca');
    const campoBusca = document.getElementById('campo-busca');
    const areaResultados = document.getElementById('resultados');

    if (!form || !campoBusca || !areaResultados) {
        return;
    }

    let temporizadorBusca;
    let requisicaoAtiva = null;

    const buscarNoticias = async () => {
        const termoBusca = campoBusca.value.trim();

        if (termoBusca === '') {
            if (requisicaoAtiva) {
                requisicaoAtiva.abort();
                requisicaoAtiva = null;
            }

            areaResultados.replaceChildren();
            areaResultados.hidden = true;
            areaResultados.setAttribute('aria-busy', 'false');
            return;
        }

        if (requisicaoAtiva) {
            requisicaoAtiva.abort();
        }

        const requisicao = new AbortController();
        requisicaoAtiva = requisicao;
        areaResultados.hidden = false;
        areaResultados.setAttribute('aria-busy', 'true');
        areaResultados.textContent = 'Buscando...';

        try {
            const corpo = new URLSearchParams(new FormData(form));
            const resposta = await fetch(form.action, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'
                },
                body: corpo,
                signal: requisicao.signal
            });

            if (!resposta.ok) {
                throw new Error(`Falha na busca: HTTP ${resposta.status}`);
            }

            const html = await resposta.text();
            if (requisicaoAtiva === requisicao) {
                areaResultados.innerHTML = html;
            }
        } catch (erro) {
            if (erro.name !== 'AbortError') {
                console.error('Não foi possível realizar a busca.', erro);
                if (requisicaoAtiva === requisicao) {
                    areaResultados.textContent = 'Não foi possível realizar a busca.';
                }
            }
        } finally {
            if (requisicaoAtiva === requisicao) {
                requisicaoAtiva = null;
                areaResultados.setAttribute('aria-busy', 'false');
            }
        }
    };

    form.addEventListener('submit', (evento) => {
        evento.preventDefault();
        window.clearTimeout(temporizadorBusca);
        buscarNoticias();
    });

    campoBusca.addEventListener('input', () => {
        window.clearTimeout(temporizadorBusca);

        if (requisicaoAtiva) {
            requisicaoAtiva.abort();
            requisicaoAtiva = null;
        }

        if (campoBusca.value.trim() === '') {
            areaResultados.replaceChildren();
            areaResultados.hidden = true;
            areaResultados.setAttribute('aria-busy', 'false');
            return;
        }

        areaResultados.hidden = false;
        areaResultados.setAttribute('aria-busy', 'true');
        areaResultados.textContent = 'Buscando...';
        temporizadorBusca = window.setTimeout(buscarNoticias, 300);
    });
})();

