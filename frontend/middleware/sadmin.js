export default function ({ store, redirect }) {
	if (!store.getters.isSadmin) {
		return redirect('/dashboard')
	}
}