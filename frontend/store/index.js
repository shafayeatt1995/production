import axios from 'axios';
export const state = () => ({
	url: process.env.URL,
	appName: '',
})

export const getters = {
	url: (state) => state.url,
	appName: (state) => state.appName,
	authentication: (state) => state.auth.loggedIn,
	user: (state) => state.auth.user,
	isSadmin: (state) => state.auth.loggedIn ? state.auth.user.role_id === 1 ? true : false : false,
	isAdmin: (state) => state.auth.loggedIn ? state.auth.user.role_id === 2 ? true : false : false,
	isStore: (state) => state.auth.loggedIn ? state.auth.user.role_id === 3 ? true : false : false,
	isCutting: (state) => state.auth.loggedIn ? state.auth.user.role_id === 4 ? true : false : false,
	isSewing: (state) => state.auth.loggedIn ? state.auth.user.role_id === 5 ? true : false : false,
	isWashing: (state) => state.auth.loggedIn ? state.auth.user.role_id === 6 ? true : false : false,
	isFinishing: (state) => state.auth.loggedIn ? state.auth.user.role_id === 7 ? true : false : false,
}

export const mutations = {
	// Get Initial Data
	setup(state, response) {
		state.appName = response.data.appName;
	},
}

export const actions = {
	// Get Initial Data
	async nuxtServerInit(context) {
		const response = await axios.get(context.state.url + 'api/app');
		context.commit('setup', response);
	},
	nuxtClientInit(context) {
		axios.get(context.state.url + 'api/app').then(
			(response) => {
				context.commit('setup', response);
			}
		)
	},
}
