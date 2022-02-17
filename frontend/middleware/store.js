export default function ({ store, redirect }) {
	if (!store.getters.isStore) {
		return redirect('/dashboard')
	}
}