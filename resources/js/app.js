import './bootstrap';

import Alpine from 'alpinejs';
import 'emoji-picker-element';

import emojiReactionForm from './emoji-picker';

window.Alpine = Alpine;
window.emojiReactionForm = emojiReactionForm;

Alpine.start();
