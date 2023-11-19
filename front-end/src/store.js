import Vuex from 'vuex';

import createPersistedState from 'vuex-persistedstate';

export default new Vuex.Store({
  plugins: [createPersistedState()],
  state: {
    isUserAuthenticated: false,
    userAccessToken: null,
  },
  mutations: {
    /**
     * Sets the value of `isUserAuthenticated` in the `state` object.
     *
     * @param {Object} state - The state object.
     * @param {Boolean} isUserAuthenticated - The new value for `isUserAuthenticated`.
     */
    SET_USER_AUTHENTICATED: (state, isUserAuthenticated) => {
      state.isUserAuthenticated = isUserAuthenticated;
    },
    /**
     * Set the user access token in the state.
     *
     * @param {type} state - The state object.
     * @param {type} userAccessToken - The user access token.
     */
    SET_USER_ACCESS_TOKEN: (state, userAccessToken) => {
      state.userAccessToken = userAccessToken;
    },
  },
  actions: {
    /**
     * Sets the user authentication state.
     *
     * @param {Object} commit - The commit function from the Vuex store.
     * @param {boolean} isUserAuthenticated - The new authentication state for the user.
     */
    setUserAuthenticated: ({ commit }, isUserAuthenticated) => {
      commit('SET_USER_AUTHENTICATED', isUserAuthenticated);
    },
    /**
     * Sets the user access token.
     *
     * @param {Object} commit - The commit object.
     * @param {string} userAccessToken - The user access token.
     * @return {void}
     */
    setUserAccessToken: ({ commit }, userAccessToken) => {
      commit('SET_USER_ACCESS_TOKEN', userAccessToken);
    },
  },
});
