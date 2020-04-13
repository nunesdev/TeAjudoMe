export default [
  {
    target: '.v-step-0',  // We're using document.querySelector() under the hood
    header: {
      title: 'Doadores',
    },
    content: `Este ícone indica os doares próximos à você no mapa`,
    params: {
      highlight: true
    }
  },
  {
    target: '.v-step-1',
    header: {
      title: 'Voluntários'
    },
    content: `Este ícone indica os voluntários próximos à você no mapa`,
    params: {
      highlight: true
    }
  },
  {
    target: '.v-step-2',
    header: {
      title: 'Centrais de Coleta'
    },
    content: `Este ícone indica um local no mapa, que está recebendo doações. Ao clicar nele você tem mais informações. Alguns recebem doações via sistema drive-thru`,
    params: {
      highlight: true
    }
  },
  {
    target: '.v-step-3',
    content: 'Mova o mapa e clique aqui para encontrar novos doares, voluntarários ou centrais de coleta.',
    params: {
      placement: 'top' // Any valid Popper.js placement. See https://popper.js.org/popper-documentation.html#Popper.placements
    }
  },
  {
    target: '.v-step-4',
    content: 'Ao clicar aqui, você será reposicionado no mapa com a sua localização.',
    params: {
      placement: 'top' // Any valid Popper.js placement. See https://popper.js.org/popper-documentation.html#Popper.placements
    }
  },
  {
    target: '.v-step-5',
    content: 'Beleza! Ao clicar aqui abre um formulário para fazer alguma doação',
    params: {
      placement: 'top' // Any valid Popper.js placement. See https://popper.js.org/popper-documentation.html#Popper.placements
    }
  },
  {
    target: '.v-step-6',
    content: 'Quer ser o voluntário? Este botão abre um formulário para você preencher algumas informações',
    params: {
      placement: 'top' // Any valid Popper.js placement. See https://popper.js.org/popper-documentation.html#Popper.placements
    }
  },
  {
    target: '.v-step-7',
    content: 'E aqui você tem acesso ao menu (sobre, campanhas, como funciona, tutorial, etc..)',
    params: {
      placement: 'top' // Any valid Popper.js placement. See https://popper.js.org/popper-documentation.html#Popper.placements
    }
  },
  {
    target: '.v-step-8',
    content: 'E aqui você tem acesso ao menu (sobre, campanhas, como funciona, tutorial, etc..)',
    params: {
      //placement: 'top' // Any valid Popper.js placement. See https://popper.js.org/popper-documentation.html#Popper.placements
    }
  }
]
