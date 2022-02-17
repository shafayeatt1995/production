export default {
	head: {
		title: '-',
		htmlAttrs: {
			lang: 'en',
		},
		meta: [
			{ charset: 'utf-8' },
			{ name: 'viewport', content: 'width=device-width, initial-scale=1' },
			{ hid: 'description', name: 'description', content: 'Lara Commerce Multivendor Ecommerce Platform' },
			{ hid: 'keywords', name: 'keywords', content: 'Ecommerce' },
			{ hid: 'author', name: 'author', content: 'AmiAnik' },
		],

		link: [
			{ rel: 'icon', type: 'image/x-icon', href: `${process.env.URL}images/icon.ico` },
		],
	},

	pageTransition: {
		name: 'fade',
		mode: 'out-in'
	},

	css: [],

	plugins: [
		'./plugins/mixin.js',
		"./plugins/pagination.js",
		"./plugins/filter.js",
		{ src: './plugins/toast.js', ssr: false },
		{ src: './plugins/sweetAlert.js', ssr: false },
	],

	components: true,

	buildModules: [],

	modules: [
		'@nuxtjs/axios',
		'@nuxtjs/dotenv',
		'@nuxtjs/auth-next',
		[
			'nuxt-fontawesome',
			{
				component: 'icon',
				imports: [
					{
						set: '@fortawesome/free-solid-svg-icons',
						icons: ['fas'],
					},
					{
						set: '@fortawesome/free-regular-svg-icons',
						icons: ['far'],
					},
					{
						set: '@fortawesome/free-brands-svg-icons',
						icons: ['fab'],
					},
				],
			},
		],
		['nuxt-lazy-load', {
			directiveOnly: true,
			defaultImage: `${process.env.URL}images/preloader.svg`,
			loadingClass: 'isLoading',
			loadedClass: 'isLoaded',
		}]
	],

	axios: {
		baseURL: `${process.env.URL}api/`,
		proxy: true,
	},

	publicRuntimeConfig: {
		axios: {
			browserBaseURL: `${process.env.URL}api/`,
		},
	},

	privateRuntimeConfig: {
		axios: {
			baseURL: `${process.env.URL}api/`,
		},
	},

	proxy: {
		'/laravel': {
			target: '/',
			pathRewrite: { '^/laravel': '/' },
		},
	},

	auth: {
		strategies: {
			laravelJWT: {
				provider: 'laravel/jwt',
				url: '/',
				endpoints: {
					login: { url: 'login', method: 'post' },
					logout: { url: 'logout', method: 'post' },
					refresh: { url: 'refresh', method: 'post' },
					user: { url: 'user', method: 'post' },
				},
				token: {
					property: 'access_token',
					maxAge: 60 * 60 * 24,
				},
				refreshToken: {
					maxAge: 20160 * 60,
				},
			},
		},
		redirect: {
			login: '/',
			logout: '/',
			home: '/dashboard'
		}
	},

	router: {
		middleware: ['auth']
	},

	build: {},
}
