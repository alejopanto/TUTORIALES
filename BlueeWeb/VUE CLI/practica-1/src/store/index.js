import { createStore } from 'vuex'

export default createStore({
  state: {
    frutas: [
      {nombre: 'Manzana', cantidad: 0},
      {nombre: 'Banana', cantidad: 0},
      {nombre: 'Pera', cantidad: 0},
    ]
  },
  mutations: {
    aumentar(state, index){
      state.frutas[index].cantidad ++
    },

    reiniciar(state){
      state.frutas.forEach(fruta => {
        fruta.cantidad = 0
      });
    }
  },
  actions: {
  },
  modules: {
  }
})
