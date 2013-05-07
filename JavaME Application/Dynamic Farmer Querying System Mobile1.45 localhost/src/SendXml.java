
import java.io.IOException;
import java.io.InputStream;
import java.io.OutputStream;
import javax.microedition.io.Connector;
import javax.microedition.io.HttpConnection;
import javax.microedition.midlet.MIDlet;

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 *
 * @author jason
 */
public class SendXml implements Runnable
{
    private String xml;
    private String language;
    private String fieldUser;
    private String password;
    private String host;
    private MIDlet midlet;
    public SendXml(String xml,String language,String fieldUser,String password,String host,MIDlet midlet)
    {
        this.language=language;
        this.xml=xml;
        this.fieldUser=fieldUser;
        this.password=password;
        this.host=host;
        this.midlet=midlet;
    }

    public void run()
    {
        if(xml!=null)
        {
            HttpConnection hc = null;
            OutputStream out = null;
            InputStream in = null;
            try
            {
                String url = "http://127.0.0.1/~jason/fulcrumDQS/phpScripts/getMobileXmlFile.php";
                hc = (HttpConnection) Connector.open(url);
                hc.setRequestMethod(HttpConnection.POST);
                hc.setRequestProperty("Content-Type", "application/x-www-form-urlencoded");//i dont think you need encoding in get
                String outData = "xml="+this.xml+"&password="+this.password; //DADatabase should be chaged if db changes
                out = hc.openOutputStream();
                out.write(outData.getBytes());
                //out.flush();
                /*in = hc.openInputStream();
                int length = (int) hc.getLength();
                byte[] inData = new byte[length];
                in.read(inData);
                String response = new String(inData); //response can either contain the name of the xml to be fetched or the errors
                */
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

                AftermathScreen result=new AftermathScreen(response, language,midlet);
                result.show();

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
    }
}
