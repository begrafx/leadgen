api = 2
core = 8.x

defaults[projects][subdir] = "contrib"

; Modules

projects[color_field][type] = module
projects[color_field][download][type] = git
projects[color_field][download][url] = http://git.drupal.org/project/color_field.git
projects[color_field][download][branch] = 8.x-2.x
projects[color_field][download][revision] = 9bbbb07f08a28d20a3896ed9b89b00e2afcb13e3
; https://www.drupal.org/node/2642712
projects[color_field][patch][] = https://www.drupal.org/files/issues/fixed-notice-2642712-2.patch

projects[ds][version] = '2.3'
projects[entity_reference_revisions][version] = '1.0-rc4'
projects[layout_plugin][version] = '1.0-alpha22'
projects[paragraphs][version] = '1.0-rc4'

; Themes

projects[bootstrap][version] = '3.0-beta2'
