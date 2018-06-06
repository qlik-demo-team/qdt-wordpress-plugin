# Qdt-components Wordpress Plugin

This is a simple plugin that uses Qdt-components to connect to your Qlik Sense server and create a mashup by getting the object with a shortcode inside a post or page within the admin panel.


### Installation ###

1. Login to your WordPress Admin Portal.
1. On the left hand navigation panel, select "Plugins". 
1. Towards the top of the plugins list, click the "Add New" button. 
1. In the search box towards the right hand side, type "qdt-component" and hit enter to search.

### How to Configure ###

Before the plugin can be used, it must be configured as follows:

1. Login to your WordPress Admin Portal.
1. On the left hand navigation panel, select "Qdt-components". 
1. Enter the relevant Qlik Sense server URL, Virtual Proxy, Port and App ID(s) to connect to your Qlik Sense server:
![Qlik Sense - Settings](/assets/Settings-server.png?raw=true "Qlik Sense - Settings")
1. If you are using a local install of Qlik Sense Desktop instead, your settings should appear as follows:
![Qlik Sense - Settings](/assets/Settings-local.png?raw=true "Qlik Sense - Settings")


### How to Use ###

The plugin utilizes a WordPress shortcode to insert Qlik Sense objects into a post or page. There are currently 3 shortcodes available to insert Qlik Sense objects, a clear selections button or the Qlik Sense selections toolbar. The shortcodes can be added manually as detailed below or alternatively, the shortcodes can be generated and inserted using the buttons provided within the WordPress text or visual post/page editor. In the text editor, place the cursor in the post/page where you wish to insert the object, then click the relevant Qlik Sense button on the editor menu. You You may be prompted to enter required parameters for the shortcode. Once complete, the shortcode will be added to the post or page.

#### qdt-component Object ###

This shortcode allows you to embed a chart, table or other Qlik Sense object. The shortcode syntax is as follows:
```
[qdt-component type="QdtViz" id="ZwjJQq" height="400"]
```
Parameters are as follows:
* type="": Only "QdtViz" is available for now to embed Qlik Sense objects. More are coming.
* id="": is the unique div id. This is needed especially when you want to display the same object in 2 different instances
* height="": The height of the visualization in pixels.
 