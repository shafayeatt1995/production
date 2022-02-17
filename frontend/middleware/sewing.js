export default function ({ store, redirect }) {
	if (!store.getters.isSewing) {
		return redirect('/dashboard')
	}
}