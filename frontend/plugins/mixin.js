import Vue from 'vue';
import { mapGetters } from 'vuex'


const GlobalData = {
	install(Vue, option) {
		Vue.mixin({
			computed: {
				...mapGetters({
					url: 'url',
					appName: 'appName',
					authCheck: 'authentication',
					user: 'user',
					sadmin: 'isSadmin',
					admin: 'isAdmin',
					store: 'isStore',
					cutting: 'isCutting',
					sewing: 'isSewing',
					washing: 'isWashing',
					finishing: 'isFinishing',

				})
			}
		})
	}
}

Vue.use(GlobalData)