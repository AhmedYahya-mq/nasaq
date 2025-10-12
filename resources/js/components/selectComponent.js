export default function selectComponent({ multiple = false, isSearch = false, value = null, options = {} } = {}) {
    return {
        open: false,
        search: '',
        multiple,
        isSearch,
        selected: multiple ? (Array.isArray(value) ? value : []) : value,
        options,

        get filteredOptions() {
            if (!this.isSearch || !this.search) return this.options;
            return Object.fromEntries(
                Object.entries(this.options).filter(([val, label]) =>
                    label.toLowerCase().includes(this.search.toLowerCase())
                )
            );
        },

        toggleOption(val) {
            if (this.multiple) {
                if (this.selected.includes(val)) {
                    this.selected = this.selected.filter(v => v !== val);
                } else {
                    this.selected.push(val);
                }
            } else {
                this.selected = val;
                this.open = false;
            }
        },

        isSelected(val) {
            return this.multiple ? this.selected.includes(val) : this.selected === val;
        },

        get displayLabel() {
            if (this.multiple) {
                return this.selected.length
                    ? this.selected.map(v => this.options[v]).join(', ')
                    : '';
            }
            return this.selected ? this.options[this.selected] : '';
        }
    };
}
