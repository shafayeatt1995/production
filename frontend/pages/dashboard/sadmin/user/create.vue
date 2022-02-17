<template>
	<div>
		<div class="section-header">
			<h1>Create User</h1>
		</div>

		<div class="section-body">
			<form class="row" @submit.prevent="submit" enctype="multipart/form-data">
				<div class="col-lg-12">
					<div class="bg-white p-3 min-h100 rounded card-primary">
						<h3 class="text-center">General Information</h3>
						<div class="image-form">
							<div class="image-frame">
								<img :src="preview" class="img-fluid max-h250" alt="avatar" v-if="form.avatar">
								<label for="logo" class="image-frame-content" v-else>
									<i>
										<icon :icon="['fas', 'cloud-upload-alt']"></icon>
									</i>
									<span>Select and upload user image</span>
								</label>
							</div>
							<label for="logo" class="image-select">
								Select Image
							</label>
							<input type="file" class="form-control" id="logo" accept="image/*" @change="image($event)">
							<p class="invalid-feedback" v-if="errors.avatar">{{errors.avatar[0]}}</p>
						</div>
						<div class="form-group">
							<label for="name">User Name</label>
							<input type="text" class="form-control" id="name" v-model="form.name">
							<p class="invalid-feedback" v-if="errors.name">{{errors.name[0]}}</p>
						</div>
						<div class="form-group">
							<label for="email">User Email</label>
							<input type="email" class="form-control" id="email" v-model="form.email">
							<p class="invalid-feedback" v-if="errors.email">{{errors.email[0]}}</p>
						</div>
						<div class="form-group">
							<label for="password">User Password</label>
							<input type="text" class="form-control" id="password" v-model="form.password">
							<p class="invalid-feedback" v-if="errors.password">{{errors.password[0]}}</p>
						</div>
						<div class="form-group">
							<label for="role">User Type</label>
							<select class="form-control" id="role" v-model="form.role_id">
								<option value="">Select a Role</option>
								<option :value="role.id" v-for="role in roles" :key="role.id">{{role.name}}</option>
							</select>
							<p class="invalid-feedback" v-if="errors.role_id">{{errors.role_id[0]}}</p>
						</div>
						<button type="submit" class="btn btn-primary mt-5">
							<transition name="fade" mode="out-in">
								<Spiner v-if="loading" />
								<span v-else>Create User</span>
							</transition>
						</button>
					</div>
				</div>
			</form>
		</div>
	</div>
</template>
<script>
	export default {
		name: "create-brand",
		middleware: "sadmin",
		head() {
			return {
				title: `Create Brand - ${this.appName}`,
			};
		},
		data() {
			return {
				form: {
					name: "",
					email: "",
					password: "",
					role_id: "",
					avatar: "",
				},
				roles: [],
				preview: "",
				errors: {},
				click: true,
				loading: false,
			};
		},
		methods: {
			//Get Roles
			getRoles() {
				this.$axios.get("role-list").then(
					(response) => {
						this.roles = response.data.roles;
					},
					(error) => {
						$nuxt.$emit("error", error);
					}
				);
			},

			// show Selected image
			image(event) {
				if (event.target.files.length > 0) {
					let file = event.target.files[0];
					let reader = new FileReader();
					if (file.size < 1048577) {
						reader.onloadend = () => {
							this.preview = reader.result;
						};
						reader.readAsDataURL(file);
						this.form.avatar = file;
					} else {
						this.$nuxt.$emit(
							"customError",
							"Please select an image less than 1 MB"
						);
					}
				}
			},

			//Submit Form
			submit() {
				if (this.click) {
					this.click = false;
					this.errors = {};
					const config = {
						headers: { "content-type": "multipart/form-data" },
					};
					let formData = new FormData();
					formData.append("name", this.form.name);
					formData.append("email", this.form.email);
					formData.append("password", this.form.password);
					formData.append("role_id", this.form.role_id);
					formData.append("avatar", this.form.avatar);
					this.$axios.post("create-user", formData, config).then(
						(response) => {
							$nuxt.$emit("success", response.data);
							this.click = true;
							this.$router.push({ name: "dashboard-sadmin-user" });
						},
						(error) => {
							this.errors = error.response.data.errors;
							this.click = true;
						}
					);
				}
			},
		},

		created() {
			this.getRoles();
		},
	};
</script>