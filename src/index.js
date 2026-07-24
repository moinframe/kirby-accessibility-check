import AccessibilityCheck from "./components/viewButtons/AccessibilityCheck.vue"

panel.plugin("moinframe/accessibility-check", {
  viewButtons: {
    'accessibility-check': AccessibilityCheck
  }
});
