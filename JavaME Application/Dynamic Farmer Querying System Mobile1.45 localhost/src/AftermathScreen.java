/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 *
 * @author jason
 */
import com.sun.lwuit.Command;
import com.sun.lwuit.Form;
import com.sun.lwuit.TextArea;
import com.sun.lwuit.events.ActionEvent;
import com.sun.lwuit.events.ActionListener;
import javax.microedition.midlet.MIDlet;
public class AftermathScreen extends Form implements ActionListener
{
    private TextArea result;
    private Command back;
    private Command exit;
    private String language;
    private String report;
    private MIDlet midlet;
    public AftermathScreen(String report,String language,MIDlet midlet)
    {
        this.addCommandListener(this);
        String text = null;
        this.language=language;
        this.report=report;
        if(report.equals("invalidUser") && language==null)
        {
            text="  ERROR!!\n"
                    + "The username or password you entered is not correct.\n"
                    + "Press 'Back' to try again or the End-call button to exit the application\n\n";
            text=text+"  KOSA!!\n"
                    + "Jina au Nywila uliopatiana si sahihi.\n"
                    + "Bonyeza 'Rudi' kujaribu tena au kidude cha kukata simu ili kufunga mpango huu.\n\n";
            back=new Command("Back/Rudi");
            this.addCommand(back);
//            exit=new Command("Exit/Toka");
//            this.addCommand(exit);

        }
        else if(report.equals("serverError") && language==null)
        {
            text="  ERROR!!\n"
                    + "There has been a problem connecting to the database!\n"
                    + "There is somebody working on it,you can call +254715023825 if this problem persists.\n"
                    + "Press 'Back' to go back to the login screen or the End-call buttton to exit this application.\n\n";
            text=text+"  SHIDA!!\n"
                    + "Kuna shida kwenye mtandao!\n"
                    + "Mtaalamu anazingatia shida hii lakini unawaza kupiga +254715023805 kama shida hii itakawia.\n"
                    + "Bonyeza 'Rudi' ili kuridi kwenye ukurasa wa kwanza au kidude cha kukata simu ili kufunga mpango huu.\n\n";
            back=new Command("Back/Rudi");
            this.addCommand(back);
//            exit=new Command("Exit/Toka");
//            this.addCommand(exit);
        }
        else if(report.equals("noApplication"))
        {
            text="  ATTENTION!!\n"
                    + "No application is available for you at the moment.\n"
                    + "Press 'Back' to go back to the login screen or the End-call button to exit this application.\n\n";
            text=text+"  TAHADHARI!!\n"
                    + "Haujaandaliwa mpango kwa sasa.\n"
                    + "Bonyeza 'Rudi' ili kuridi kwenye ukurasa wa kwanza au kidude cha kukata simu ili kufunga mpango huu.\n\n";
            back=new Command("Back/Rudi");
            this.addCommand(back);
//            exit=new Command("Exit/Toka");
//            this.addCommand(exit);
        }
        else if(report.equals("invalidUser") && language.equals("English"))
        {
            text="  ERROR!!\n"
                    + "The username or password you entered is not correct.\n"
                    + "Press 'Back' to try again or the End-call button to exit the application\n\n";
            back=new Command("Back");
            this.addCommand(back);
//            exit=new Command("Exit");
//            this.addCommand(exit);
        }
        else if(report.equals("invalidUser") && language.equals("Kiswahili"))
        {
            text="  KOSA!!\n"
                    + "Jina au Nywila uliopatiana si sahihi.\n"
                    + "Bonyeza 'Rudi' kujaribu tena au kidude cha kukata simu ili kufunga mpango huu.\n\n";
            back=new Command("Rudi");
            this.addCommand(back);
//            exit=new Command("Toka");
//            this.addCommand(exit);
        }
        else if(report.equals("serverError") && language.equals("English"))
        {
            text="  ERROR!!\n"
                    + "There has been a problem connecting to the database!\n"
                    + "There is somebody working on it,you can call +254715023825 if this problem persists.\n"
                    + "Press 'Back' to go back to the login screen or the End-call button to exit this application.\n\n";
            back=new Command("Back");
            this.addCommand(back);
//            exit=new Command("Exit");
//            this.addCommand(exit);
        }
        else if(report.equals("serverError") && language.equals("Kiswahili"))
        {
            text="  SHIDA!!\n"
                    + "Kuna shida kwenye mtandao!\n"
                    + "Mtaalamu anazingatia shida hii lakini unawaza kupiga +254715023805 kama shida hii itakawia.\n"
                    + "Bonyeza 'Rudi' ili kuridi kwenye ukurasa wa kwanza au kidude cha kukata simu ili kufunga mpango huu.\n\n";
            back=new Command("Rudi");
            this.addCommand(back);
//            exit=new Command("Toka");
//            this.addCommand(exit);
        }
        else if(report.equals("success") && language.equals("English"))
        {
            text="  SUCCESS!!\n"
                    + "Your response has been successfully uploaded to the server.\n"
                    + "Press 'Back' to go back to the login screen or the End-call button to exit this application.\n\n";
            back=new Command("Back");
            this.addCommand(back);
//            exit=new Command("Exit");
//            this.addCommand(exit);
        }
        else if(report.equals("success") && language.equals("Kiswahili"))
        {
            text="  UMEFUALU!!\n"
                    + "Majibu yako yamewasilishwa kwenye mtandao.\n"
                    + "Bonyeza 'Rudi' ili kuridi kwenye ukurasa wa kwanza au kidude cha kukata simu ili kufunga mpango huu.\n\n";
            back=new Command("Rudi");
            this.addCommand(back);
//            exit=new Command("Toka");
//            this.addCommand(exit);
        }
        else if(report.equals("killed"))
        {
        }
        result=new TextArea(text);
        //formatting for the textCount area
        this.result.setEditable(false);
        this.result.setFocusable(false);
        this.result.getStyle().setBgTransparency(0);
        this.result.getStyle().setBorder(null);

        this.addComponent(this.result);
    }

    public void actionPerformed(ActionEvent evt)
    {
            if(evt.getCommand()==back)
            {
                Midlet.login.show();
            }
//            else if(evt.getCommand()==exit)
//            {
//                midlet.notifyDestroyed();
//            }
    }

}
