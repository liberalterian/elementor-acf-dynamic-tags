<?php 


if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}



/**
 * Elementor Dynamic Tag - ACF Text Tag
 *
 * Elementor dynamic tag that returns an ACF field.
 *
 * @since 1.0.0
 */

 class ACF_Dynamic_Text_Tag extends \Elementor\Core\DynamicTags\Tag {

	/**
	 * Get dynamic tag name.
	 *
	 * Retrieve the name of the ACF text tag.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return string Dynamic tag name.
	 */
	public function get_name() {
		return 'acf-text';
	}

	/**
	 * Get dynamic tag title.
	 *
	 * Returns the title of the ACF text tag.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return string Dynamic tag title.
	 */
	public function get_title() {
		return esc_html__( 'ACF Text', 'elementor-acf-dynamic-tags' );
	}

	/**
	 * Get dynamic tag groups.
	 *
	 * Retrieve the list of groups the ACF text tag belongs to.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return array Dynamic tag groups.
	 */
	public function get_group() {
		return [ 'site' ];
	}

	/**
	 * Get dynamic tag categories.
	 *
	 * Retrieve the list of categories the ACF text tag belongs to.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return array Dynamic tag categories.
	 */
	public function get_categories() {
		return [ \Elementor\Modules\DynamicTags\Module::TEXT_CATEGORY ];
	}

	/**
	 * Register dynamic tag controls.
	 *
	 * Add input fields to allow the user to customize the ACF text tag settings.
	 *
	 * @since 1.0.0
	 * @access protected
	 * @return void
	 */
	protected function register_controls() {
		$this->add_control(
			'acf_field',
			[
				'label' => esc_html__( 'Field', 'elementor-acf-dynamic-tags' ),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => $this->get_acf_fields(),
			]
		);
	}

	/**
	 * Render tag output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return void
	 */
	public function render() {
		$field = $this->get_settings('acf_field');

        // do_action('php_console_log', var_dump([ 'name' => $field, 'post_id' => get_queried_object_id() ]));

        if (empty($field)) {
            return;
        }

        $value = get_field_object($field, get_queried_object_id());

        // do_action('php_console_log', var_dump([ 'msg' => 'VALUE', 'value' => $value ]));

		if ( ! empty($value) ) {
			if ( $value['value'] == null ) {
				echo wp_kses_post($value['default_value']);
			} else {
				echo wp_kses_post($value['value']);
			}
		} else {
			return;
		}
	}

    private function get_acf_fields() {
        $fields = array();
        do_action( 'php_console_log', 'START DEBUG LOG'); 
        $acf_groups = acf_get_field_groups();
        // do_action( 'php_console_log', var_dump($acf_groups)); 
        foreach ($acf_groups as $group) {
            $group_fields = acf_get_fields($group);
            foreach ($group_fields as $field) {
                if (in_array($field['type'], ['text', 'textarea', 'number', 'email', 'url', 'password', 'wysiwyg'])) {
                    // do_action('php_console_log', var_dump($field));
                    // $fields[$field['label']] = $field['value'];
                    $fields[$field['name']] = esc_html__( $field['label'] , 'elementor-acf-dynamic-tags' );
                }
            }
        }
        // do_action( 'php_console_log', var_dump($fields)); 

        return $fields;
    }

}

/*

class ACF_Text_Tag extends \Elementor\Core\DynamicTags\Tag {

    public function get_name() {
        return 'acf-text';
    }

    public function get_title() {
        return __('ACF Text Field', 'acf-dynamic-tags');
    }

    public function get_group() {
        return 'acf';
    }

    public function get_categories() {
        return [\Elementor\Modules\DynamicTags\Module::TEXT_CATEGORY];
    }

    protected function register_controls() {
        $this->add_control(
			'acf_field',
			[
				'label' => esc_html__( 'Field', 'elementor-acf-dynamic-tags' ),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => $this->get_acf_fields(),
			]
		);
    }

    public function render() {
        $field_name = $this->get_settings('acf_field');
        if (empty($field_name)) {
            return;
        }

        $value = get_field($field_name);
        echo wp_kses_post($value);
    }

    private function get_acf_fields() {
        $fields = [];

        $acf_groups = acf_get_field_groups();
        foreach ($acf_groups as $group) {
            $group_fields = acf_get_fields($group);
            foreach ($group_fields as $field) {
                if (in_array($field['type'], ['text', 'textarea', 'number', 'email', 'url', 'password', 'wysiwyg'])) {
                    $fields[] = [
                        'label' => $field['label'],
                        'value' => $field['name'],
                    ];
                }
            }
        }

        do_action('php_console_log', var_dump($fields));

        return $fields;
    }
}

*/