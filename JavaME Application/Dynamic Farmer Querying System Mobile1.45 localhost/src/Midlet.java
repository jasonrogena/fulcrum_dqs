/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

import com.sun.lwuit.Command;
import com.sun.lwuit.events.ActionEvent;
import javax.microedition.midlet.*;
import com.sun.lwuit.Display;
import com.sun.lwuit.Form;
import com.sun.lwuit.Image;
import com.sun.lwuit.Label;
import com.sun.lwuit.TextArea;
import com.sun.lwuit.TextField;
import com.sun.lwuit.events.ActionListener;
import com.sun.lwuit.layouts.BorderLayout;
import com.sun.lwuit.layouts.BoxLayout;
import java.io.IOException;
import java.io.InputStream;
import java.io.OutputStream;
import javax.microedition.io.Connector;
import javax.microedition.io.HttpConnection;
//import customNet.URLEncoder;
//import java.io.UnsupportedEncodingException;
import javax.microedition.io.StreamConnection;
import org.xmlpull.v1.XmlPullParserException;


/**
 * @author jason
 */
public class Midlet extends MIDlet implements ActionListener,Runnable
{
    protected Application application;
    public static Form login;
    private Label usernameLabel;
    private TextField username;
    private Label passwordLabel;
    private TextField password;
    //private Label host;
    //private TextField hostN;
    private Command loginEnter;
    protected String usernameString;
    protected String passwordString;
    protected String hostString;
    protected InputStream httpInput;
    private Form network;
    private TextArea loading;
    private Command cancel;
    public void startApp()
    {
        Display.init(this);
        login=new Form("Login");
        login.setLayout(new BoxLayout(BoxLayout.Y_AXIS));
        usernameLabel=new Label("Username / Jina:");
        login.addComponent(usernameLabel);
        username=new TextField();
        username.setInputMode("abc");
        login.addComponent(username);
        passwordLabel=new Label("Password / Nywila:");
        login.addComponent(passwordLabel);
        password=new TextField();
        password.setConstraint(TextField.PASSWORD);
        password.setInputMode("abc");
        login.addComponent(password);
        //host=new Label("Host Name");
        //login.addComponent(host);
        //hostN=new TextField();
        //hostN.setInputMode("abc");
        //login.addComponent(hostN);
        login.addCommandListener(this);
        login.addCommand(new Command(""));//phantom command
        loginEnter=new Command("Enter/Ingia");
        login.addCommand(loginEnter);
        network=new Form();
        network.setLayout(new BorderLayout());
        loading=new TextArea("LOADING .....");
        this.loading.setEditable(false);
        this.loading.setFocusable(false);
        this.loading.getStyle().setBgTransparency(0);
        this.loading.getStyle().setBorder(null);
        network.addComponent(BorderLayout.CENTER,loading);
        network.addCommandListener(this);
        cancel=new Command("Cancel/Funga");
        network.addCommand(cancel);
        login.show();
    }

    public void pauseApp()
    {

    }

    public void destroyApp(boolean unconditional)
    {
        notifyDestroyed();
    }
    public void run()
    {
        HttpConnection hc=null;
        OutputStream out=null;
        InputStream in=null;
        String url="http://127.0.0.1/~jason/fulcrumDQS/phpScripts/mobileUserValidation.php";
        try
        {
            hc = (HttpConnection) Connector.open(url);
            hc.setRequestMethod(HttpConnection.POST);
            hc.setRequestProperty("User-Agent","Profile/MIDP-1.0 Confirguration/CLDC-1.0");
            hc.setRequestProperty("Content-Type","application/x-www-form-urlencoded");
            String outData="username="+usernameString+"&password="+passwordString;//DADatabase should be chaged if db changes
            /*try
            {
                encodedData=URLEncoder.encode(outData, "UTF-8");
            }
            catch(UnsupportedEncodingException uee)
            {
                System.err.print(uee+"unsupported encoding exception");
            }*/
            out=hc.openOutputStream();
            out.write(outData.getBytes());
            //out.flush();

              //in=hc.openInputStream();
              //int length=(int)hc.getLength();
              //byte[] inData=new byte[length];
              //in.read(inData);
              //String response=new String(inData);//response can either contain the name of the xml to be fetched or the errors
            StringBuffer stringBuffer = new StringBuffer();
            in = hc.openDataInputStream();
            int chr;
            while ((chr = in.read()) != -1)
            {
                stringBuffer.append((char) chr);
            }
             String response=stringBuffer.toString();
            if(response.endsWith("invalidUser"))//strip the php text from response
            {
                response="invalidUser";
            }
            else if(response.endsWith("serverError"))
            {
                response="serverError";
            }
            else if(response.endsWith("noApplication"))
            {
                response="noApplication";
            }

            
            if(response.equals("invalidUser") || response.equals("serverError") || response.equals("noApplication"))//username or password not in database
            {
                AftermathScreen error=new AftermathScreen(response, null,this);
                error.show();
            }
            else//the xml file name
            {
                url="http://127.0.0.1/~jason/fulcrumDQS/xml/"+response;
                HttpConnection sc=(HttpConnection) Connector.open(url);
                httpInput=sc.openInputStream();
                start();
            }
            
        }
        catch (Exception ex)
        {
            ex.printStackTrace();
        }
        finally
        {
            if(in!= null)
            {
                try
                {
                    in.close();
                }
                catch (IOException ex)
                {
                    ex.printStackTrace();
                }
            }
            if(out != null)
            {
                try
                {
                    out.close();
                }
                catch (IOException ex)
                {
                    ex.printStackTrace();
                }
            }
            if(hc != null)
            {
                try
                {
                    hc.close();
                }
                catch (IOException ex)
                {
                    ex.printStackTrace();
                }
            }
        }
    }
    public void start()
    {
        XmlParser xmlParser=new XmlParser(httpInput);
        try
        {
            application=new Application(null, 0, null, null, null);
            application = xmlParser.parse();
            application.startApplication(usernameString,passwordString,hostString,this);
        }
        catch (XmlPullParserException ex)
        {
            ex.printStackTrace();
        }
        catch (IOException ex)
        {
            ex.printStackTrace();
        }
        catch (NullPointerException nx)
        {
            nx.printStackTrace();
        }   
    }
    public void actionPerformed(ActionEvent evt)
    {
        Thread run=new Thread(this);
        if(evt.getCommand()==loginEnter)
        {
            usernameString=username.getText();
            passwordString=password.getText();
            hostString="www.kaymonneydesigns.com/jason";//the hostname here it will be changed golbally
            network.show();
            run.start();

        }
        else if(evt.getCommand()==cancel)
        {
            run.interrupt();
            login.show();
        }
    }
    public static void xmlGenerator(GlobalData data)
    {
        String xml="<?xml version=\"1.0\" encoding=\"UTF-8\"?>";
        xml=xml+"<response>";//make sure you close this tag
        xml=xml+"<fieldUser>"+data.fieldUser+"</fieldUser>";
        xml=xml+"<applicationID>"+data.applicationID+"</applicationID>";
        String questionSize=Integer.toString(data.responses.length);
        xml=xml+"<queries size=\""+questionSize+"\">";//make sure you close this tag
        int count=0;
        while(count<data.responses.length)
        {
            if(data.responses[count]!=null)
            {
                xml=xml+data.responses[count].getXml();
            }
            count++;
        }
        count=0;
        xml=xml+"</queries></response>";
        SendXml tread=new SendXml(xml,data.language,data.fieldUser,data.password,data.hostName,data.midlet);
        Thread run2=new Thread(tread);
        Form network;
        TextArea loading;
        network=new Form();
        network.setLayout(new BorderLayout());
        loading=new TextArea("LOADING .....");
        loading.setEditable(false);
        loading.setFocusable(false);
        loading.getStyle().setBgTransparency(0);
        loading.getStyle().setBorder(null);
        network.addComponent(BorderLayout.CENTER,loading);
        network.show();
        run2.start();//start the thread
    }
}
