<?php 


if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}



/**
 * Elementor Dynamic Tag - ACF Image Tag
 *
 * Elementor dynamic tag that returns an ACF field.
 *
 * @since 1.0.0
 */

 class ACF_Dynamic_Image_Tag extends Elementor\Core\DynamicTags\Data_Tag {

	/**
	 * Get dynamic tag name.
	 *
	 * Retrieve the name of the ACF image tag.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return string Dynamic tag name.
	 */
	public function get_name() {
		return 'acf-image';
	}

	/**
	 * Get dynamic tag title.
	 *
	 * Returns the title of the ACF image tag.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return string Dynamic tag title.
	 */
	public function get_title() {
		return esc_html__( 'ACF Image', 'eacfdt' );
	}

	/**
	 * Get dynamic tag groups.
	 *
	 * Retrieve the list of groups the ACF image tag belongs to.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return array Dynamic tag groups.
	 */
	public function get_group() {
		return [ 'acf-fields' ];
	}

	/**
	 * Get dynamic tag categories.
	 *
	 * Retrieve the list of categories the ACF image tag belongs to.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return array Dynamic tag categories.
	 */
	public function get_categories() {
		return [ \Elementor\Modules\DynamicTags\Module::IMAGE_CATEGORY ];
	}

	/**
	 * Register dynamic tag controls.
	 *
	 * Add input fields to allow the user to customize the ACF image tag settings.
	 *
	 * @since 1.0.0
	 * @access protected
	 * @return void
	 */
	protected function register_controls() {
		$this->add_control(
			'acf_img_field',
			[
				'label' => esc_html__( 'Field', 'eacfdt' ),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => $this->get_acf_fields(),
			]
		);
	}  

    /**
	 * Get the Image URL and ID from an ACF Image field.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return void
	 */
    public function get_value(array $options = []) {
        $field_name = $this->get_settings('acf_img_field');

        if (empty($field_name)) {
            return false;
        }

        $field = get_field_object($field_name, get_queried_object_id()); 

        $data_image = [
            'id' => 0,
            'url' => ''
        ];

        if ( ! isset( $field ) ) {
            return $data_image;
        }

		if ( is_array( $field ) ) {
			switch ( $field['return_format'] ) {
				case 'array':
					$data_image = array(
						'id'  => $field['id'],
						'url' => $field['url'],
					);
					break;
				case 'url':
					$data_image = array(
						'id'  => attachment_url_to_postid( $field['value'] ), // @since 1.8.7
						'url' => $field['value']
					);
					break;
				case 'id':
					$data_image = array(
						'id'  => $field['value'],
						'url' => wp_get_attachment_url( $field['value'] )
					);
					break;
			}
		}

        return $data_image;
    }      

    private function get_acf_fields() {
        $fields = array();
        $acf_groups = acf_get_field_groups();
        foreach ($acf_groups as $group) {
            $group_fields = acf_get_fields($group);
            foreach ($group_fields as $field) {
                if (in_array($field['type'], ['image'])) {
                    $fields[$field['name']] = esc_html__( $field['label'] , 'eacfdt' );
                }
            }
        }

        return $fields;
    }

}
