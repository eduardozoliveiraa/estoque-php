function flutuacaoC() {
    var Nelemento = document.getElementById("numero-elementos").value;
    var tensaoMinima = parseFloat(document.getElementById("tensao-minima").value);
    var tensaoMaxima = parseFloat(document.getElementById("tensao-maxima").value);
  
    const flutMin = 2.18;
    const flutMax = 2.22;
    const flut = 2.2;
    const recarga = 1.42;
  
    var tensaoFlut = flut * Nelemento;
  
    var flutuacaoMsg = `Tensão de flutuação deve ser de ${tensaoFlut.toFixed(
      2
    )} V.`;
  
    var recargaMsg = `Tensão de recarga deve ser de ${recarga.toFixed(2)} V.`;
    var minimaMsg = `Tensão mínima deve estar entre ${tensaoMinima} e ${tensaoMaxima} V.`;
  
    document.getElementById("flutuacao").innerHTML = flutuacaoMsg;
    document.getElementById("rec").innerHTML = recargaMsg;
    document.getElementById("min").innerHTML = minimaMsg;
  }
  
  
  function verificarTeclaPressionada(event) {
    if (event.keyCode === 13) {
      flutuacaoC();
    }
  }
  
  function criarTabela() {
    var tamanho = parseInt(document.getElementById("numero-elementos").value);
    var tabelaContainer = document.getElementById("tabelaContainer");
    tabelaContainer.innerHTML = ""; // Limpar conteúdo anterior
    var tabela = document.createElement("table");
  
    var numColunas = 5;
    var numLinhas = Math.ceil(tamanho / numColunas); 
  
    for (var i = 0; i < numLinhas; i++) {
      var linha = document.createElement("tr");
  
      for (var j = 0; j < numColunas; j++) {
        var index = i * numColunas + j; 
  
        if (index < tamanho) {
          var coluna = document.createElement("td");
          coluna.textContent = index + 1 + ".";
  
          var input = document.createElement("input");
          input.type = "text";
          input.placeholder = "Digite um valor";
          input.classList.add("inputPersonalizado");
  
          input.addEventListener("input", function () {
            this.value = this.value.replace(".", ",");
  
            var valor = parseFloat(this.value.replace(",", "."));
            if (valor < 2.18 || valor > 2.22) {
              this.style.backgroundColor = "rgba(255, 0, 0, 0.3)";
            } else {
              this.style.backgroundColor = "";
            }
          });
          input.addEventListener("keydown", function (event) {
            if (event.keyCode === 13) {
              event.preventDefault(); 
  
              var inputs = tabelaContainer.getElementsByTagName("input");
              var currentIndex = Array.prototype.indexOf.call(inputs, this);
              var nextIndex = currentIndex + 1;
  
              if (nextIndex < inputs.length) {
                inputs[nextIndex].focus();
              }
            }
          });
  
          coluna.appendChild(input);
          linha.appendChild(coluna);
        } else {
          var colunaVazia = document.createElement("td");
          linha.appendChild(colunaVazia);
        }
      }
  
      tabela.appendChild(linha);
    }
  
    tabelaContainer.appendChild(tabela);
  
    var divMedia = document.createElement("div");
    divMedia.id = "media";
    tabelaContainer.appendChild(divMedia);
  
    var botaoCalcular = document.createElement("button");
    botaoCalcular.textContent = "Calcular Média";
    botaoCalcular.type = "button";
    botaoCalcular.addEventListener("click", function () {
      var inputs = tabelaContainer.getElementsByTagName("input");
      var soma = 0;
      var contador = 0;
  
      for (var i = 0; i < inputs.length; i++) {
        var valor = parseFloat(inputs[i].value.replace(",", "."));
        if (!isNaN(valor)) {
          soma += valor;
          contador++;
        }
      }
  
      if (contador > 0) {
        var media = soma / contador;
        divMedia.textContent = "Média: " + media.toFixed(2).replace(".", ","); 
  
        for (var i = 0; i < inputs.length; i++) {
          var valor = parseFloat(inputs[i].value.replace(",", ".")); 
          if (!isNaN(valor)) {
            if (valor < 2.18 || valor > 2.22) {
              inputs[i].style.backgroundColor = "rgba(255, 0, 0, 0.3)";
            } else {
              inputs[i].style.backgroundColor = "";
            }
          }
        }
      }
    });
  
    tabelaContainer.appendChild(botaoCalcular);
  }
  
  var botaoMedir = document.createElement("button");
  botaoMedir.textContent = "Medir";
  botaoMedir.addEventListener("click", function () {
    var linhas = tabela.querySelectorAll("tr");
  
    for (var i = 0; i < linhas.length; i++) {
      var colunas = linhas[i].querySelectorAll("td");
      var inputValor = colunas[0].querySelector("input");
      var valor = parseFloat(inputValor.value);
  
      var tensaoMin = 2.18;
      var tensaoMax = 2.22;
  
      if (valor >= tensaoMin && valor <= tensaoMax) {
        colunas[1].textContent = "Dentro do intervalo";
      } else {
        colunas[1].textContent = "Fora do intervalo";
      }
  
      var impedancia = 0.0;
      var impedanciaMax = 10.0;
  
      if (impedancia <= impedanciaMax) {
        colunas[2].textContent = "Dentro do limite";
      } else {
        colunas[2].textContent = "Fora do limite";
      }
    }
  });
  
  // var primeiraLinha = tabela.getElementsByTagName("tr")[0];
  // primeiraLinha.classList.add("corDeFundoPersonalizada");
  
  // function calcularValorReferencia() {
  //   var inputs = tabelaContainer.getElementsByTagName("input");
  //   var valores = [];
  
  //   for (var i = 0; i < inputs.length; i++) {
  //     var valor = parseFloat(inputs[i].value);
  //     if (!isNaN(valor)) {
  //       valores.push(valor);
  //     }
  //   }
  
  //   if (valores.length > 0) {
  //     var percentual = 0.4; // 40% dos maiores valores
  //     var qtdValores = Math.ceil(valores.length * percentual);
  //     var valoresOrdenados = valores.sort(function (a, b) {
  //       return b - a;
  //     }); // Ordenar valores em ordem decrescente
  
  //     var valoresMaiores = valoresOrdenados.slice(0, qtdValores); // Pegar os valores maiores
  //     var valorReferencia =
  //       valoresMaiores.reduce(function (acc, val) {
  //         return acc + val;
  //       }, 0) / valoresMaiores.length;
  
  //     var divValorReferencia = document.createElement("div");
  //     divValorReferencia.textContent =
  //       "Valor de referência: " + valorReferencia.toFixed(2);
  //     tabelaContainer.appendChild(divValorReferencia);
  //   }
  // }