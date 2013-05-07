
import com.sun.lwuit.Form;
import com.sun.lwuit.Image;
import com.sun.lwuit.layouts.BorderLayout;
import java.io.IOException;
import java.util.TimerTask;

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 *
 * @author jason
 */
public class Splash extends TimerTask
{

    public void run()
    {
        Form splashScreen=new Form();
        splashScreen.setLayout(new BorderLayout());
        Image logo=null;
        try
        {
            logo = Image.createImage("/mobi.jpg");
        }
        catch (IOException ex)
        {
            ex.printStackTrace();
        }
        splashScreen.setBgImage(logo);
        splashScreen.show();
    }

}
