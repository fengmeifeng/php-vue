/*
 * @Author: wangyi
 * @Date: 2019-11-25 09:12:27
 * @LastEditTime: 2020-04-22 14:55:08
 * @LastEditors: Please set LastEditors
 * @Description: store
 * @FilePath: /admin/src/store/index.js
 */
import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex)

export default new Vuex.Store({
  state: {
    allBtns: [],
    currentPageBtns: [],
    currentItemBtns: []
  },
  getters: {
    allBtns (state) {
      return state.allBtns
    },
    currentPageBtns (state) {
      return state.currentPageBtns
    },
    currentItemBtns (state) {
      return state.currentItemBtns
    }
  },
  mutations: {
    useAllBtns (state, value) {
      state.allBtns = value
    },
    currentPageBtns (state, value) {
      state.currentPageBtns = value
      console.info('页面btns')
      console.info(state.currentPageBtns)
    },
    currentItemBtns (state, value) {
      state.currentItemBtns = value
      console.info('列表btns')
      console.info(state.currentItemBtns)
    }
  },
  actions: {
    usingCurrentPageBtns (context, value) {
      context.commit('currentPageBtns', value)
    },
    usingCurrentItemBtns (context, value) {
      context.commit('currentItemBtns', value)
    }
  },
  modules: {}
})
