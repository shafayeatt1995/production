<template>
	<div class="main-sidebar sidebar-style-2" :class="active ? 'active':''">
		<aside id="sidebar-wrapper">
			<div class="sidebar-brand">
				<!-- <img :src="`${url}images/logo.png`" alt="logo" class="img-fluid px-5"> -->
			</div>
			<ul class="sidebar-menu" v-if="sadmin">
				<li>
					<nuxt-link :to="{name: 'dashboard'}" class="nav-link">
						<i>
							<icon :icon="['fas', 'tachometer-alt']"></icon>
						</i>
						<span>Dashboard</span>
					</nuxt-link>
				</li>
				<li class="sidebar-dropdown">
					<a href="#" class="has-dropdown" :class="buyer || route.substring(18, 23) === 'buyer' ? 'dropdown-active' : ''" @click.prevent="buyer = !buyer">
						<i>
							<icon :icon="['fas', 'user-tie']"></icon>
						</i>
						<span>Buyer
							<i :class="buyer">
								<icon :icon="['fas', 'chevron-right']"></icon>
							</i>
						</span>
					</a>
					<transition name="slide" mode="out-in">
						<ul class="sidebar-dropdown-menu" v-if="buyer || route.substring(18, 23) === 'buyer'">
							<li>
								<nuxt-link :to="{name: 'dashboard-sadmin-buyer'}">All Buyer</nuxt-link>
							</li>
							<li>
								<nuxt-link :to="{name: 'dashboard-sadmin-buyer-create'}">Create Buyer</nuxt-link>
							</li>
						</ul>
					</transition>
				</li>
				<li class="sidebar-dropdown">
					<a href="#" class="has-dropdown" :class="style || route.substring(18, 23) === 'style' ? 'dropdown-active' : ''" @click.prevent="style = !style">
						<i>
							<icon :icon="['fas', 'vest']"></icon>
						</i>
						<span>Style
							<i :class="style">
								<icon :icon="['fas', 'chevron-right']"></icon>
							</i>
						</span>
					</a>
					<transition name="slide" mode="out-in">
						<ul class="sidebar-dropdown-menu" v-if="style || route.substring(18, 23) === 'style'">
							<li>
								<nuxt-link :to="{name: 'dashboard-sadmin-style'}">All Style</nuxt-link>
							</li>
							<li>
								<nuxt-link :to="{name: 'dashboard-sadmin-style-create'}">Create Style</nuxt-link>
							</li>
						</ul>
					</transition>
				</li>
				<li class="sidebar-dropdown">
					<a href="#" class="has-dropdown" :class="sidebarUser || route.substring(18, 22) === 'user' ? 'dropdown-active' : ''" @click.prevent="sidebarUser = !sidebarUser">
						<i>
							<icon :icon="['fas', 'users']"></icon>
						</i>
						<span>User
							<i :class="sidebarUser">
								<icon :icon="['fas', 'chevron-right']"></icon>
							</i>
						</span>
					</a>
					<transition name="slide" mode="out-in">
						<ul class="sidebar-dropdown-menu" v-if="sidebarUser || route.substring(18, 22) === 'user'">
							<li>
								<nuxt-link :to="{name: 'dashboard-sadmin-user'}">All User</nuxt-link>
							</li>
							<li>
								<nuxt-link :to="{name: 'dashboard-sadmin-user-create'}">Create User</nuxt-link>
							</li>
						</ul>
					</transition>
				</li>
			</ul>
			<ul class="sidebar-menu" v-if="admin">
			</ul>
		</aside>
	</div>
</template>
<script>
	export default {
		props: {
			active: "",
		},

		data() {
			return {
				route: "",
				sidebarUser: false,
				buyer: false,
				style: false,
			};
		},

		methods: {},

		created() {
			this.route = this.$route.path;
		},

		watch: {
			$route(to, from) {
				this.route = to.path;
			},
		},
	};
</script>