/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 *
 * @author jason
 */
import com.sun.lwuit.Component;
import com.sun.lwuit.Form;
import com.sun.lwuit.ButtonGroup;
import com.sun.lwuit.Calendar;
import com.sun.lwuit.CheckBox;
import com.sun.lwuit.ComboBox;
import com.sun.lwuit.Command;
import com.sun.lwuit.Dialog;
import com.sun.lwuit.Label;
import com.sun.lwuit.List;
import com.sun.lwuit.RadioButton;
import com.sun.lwuit.TextArea;
import com.sun.lwuit.TextField;
import com.sun.lwuit.layouts.BoxLayout;
import com.sun.lwuit.table.TableLayout;
import com.sun.lwuit.events.*;
import com.sun.lwuit.geom.Dimension;
import com.sun.lwuit.list.ListCellRenderer;
import java.util.Date;
/**
 *
 * @author jason
 */
public class DynamicScreen extends Form implements ActionListener
{
    private int screenNo;
    private String screenType;
    private TextArea question;
    private int questionNo;
    private MyComboBox day;
    private MyComboBox month;
    private MyComboBox year;
    private MyComboBox hour;
    private MyComboBox min;
    private MyComboBox sec;
    private Command next;
    private Command previous;
    private Response response;
    private int prevScreen;
    private TextArea heading;
    private TextArea introText;
    private Command start;
    private GlobalData data;
    private TextArea text;//includes both heading and introduction textCount
    private TextField[] answers;
    private MyCheckBox[] checkBChoices;
    private int[] nextScreens;
    private MyCheckBox checkBOther;
    private TextField specify;
    private TextArea answer;
    private String[] ranks;
    private MyComboBox[] positions;
    private MyRadioButton[] eachChoice;
    private ButtonGroup buttonGChoices;
    private MyRadioButton radioBOther;
    private int dateTime;
    private String language;//used in date screen only
    private int dateFlag;
    //constructor overloading!!!!
    /**
     *   FOR DATE SCREEN
     * @param screenType
     * @param screenNo
     * @param language
     * @param question
     * @param questionNo
     * @param dateTime
     */
    public DynamicScreen(String screenType,int screenNo,String question,int questionNo,String language,int dateTime)
    {
        dateFlag=0;
        this.screenType=screenType;
        this.language=language;
        this.addCommandListener(this);
        TableLayout layout=new TableLayout(6,5);
        this.setLayout(layout);
        this.dateTime=dateTime;
        TableLayout.Constraint constraints=layout.createConstraint();
        constraints.setHorizontalSpan(5);
        this.screenNo=screenNo;
        this.questionNo=questionNo;
        this.question=new TextArea(question);
        //formatting for the textCount area
        this.question.setEditable(false);
        this.question.setFocusable(false);
        this.question.getStyle().setBgTransparency(0);
        this.question.getStyle().setBorder(null);

        this.addComponent(constraints, this.question);

        String[] days;
        String[] months;
        String[] years;
        String[] hours;
        String[] mins;
        if(dateTime==2)//date and time
        {
            Label date;
            if(language.equals("English"))
            {
                date=new Label("Date :");
            }
            else if(language.equals("Kiswahili"))
            {
                date=new Label("Siku :");
            }
            else
            {
                date=new Label();
            }
            constraints=layout.createConstraint();
            constraints.setHorizontalSpan(5);
            this.addComponent(constraints,date);

            days=new String[31];
            int count=0;
            while(count<31)
            {
                days[count]=Integer.toString(count + 1);
                count++;
            }
            count=0;
            day=new MyComboBox(days);
            day.setListCellRenderer(new MyListCellRenderer(days));
            constraints=layout.createConstraint();
            constraints.setWidthPercentage(20);
            this.addComponent(constraints,this.day);

            Label forMonth=new Label("/");
            constraints=layout.createConstraint();
            constraints.setWidthPercentage(5);
            this.addComponent(constraints,forMonth);

            months=new String[12];
            if(language.equals("English"))
            {
                months[0]="January";
                months[1]="February";
                months[2]="March";
                months[3]="April";
                months[4]="May";
                months[5]="June";
                months[6]="July";
                months[7]="August";
                months[8]="September";
                months[9]="October";
                months[10]="November";
                months[11]="December";
            }
            else if(language.equals("Kiswahili"))
            {
                months[0]="Januari";
                months[1]="Februari";
                months[2]="Machi";
                months[3]="Aprili";
                months[4]="Mei";
                months[5]="Juni";
                months[6]="Julai";
                months[7]="Agosti";
                months[8]="Septemba";
                months[9]="Octoba";
                months[10]="Novemba";
                months[11]="Decemba";
            }
            else
            {
                int c=0;
                while(c<12)
                {
                    months[c]=null;
                    c++;
                }
            }
            month=new MyComboBox(months);
            month.setListCellRenderer(new MyListCellRenderer(months));
            constraints=layout.createConstraint();
            constraints.setWidthPercentage(33);
            this.addComponent(constraints,this.month);

            Label forYear=new Label("/");
            constraints=layout.createConstraint();
            constraints.setWidthPercentage(5);
            this.addComponent(constraints,forYear);

            count=1;
            int offSet=1929;
            years=new String[102];
            years[0]="Before 1930";
            while(count<101)
            {
                years[count]=Integer.toString(offSet+count);
                count++;
            }
            years[101]="After 2029";
            year=new MyComboBox(years);
            year.setListCellRenderer(new MyListCellRenderer(years));
            year.addActionListener(this);
            constraints=layout.createConstraint();
            constraints.setWidthPercentage(37);
            this.addComponent(constraints,this.year);

            Label time;
            if(language.equals("English"))
            {
                time=new Label("Time :");
            }
            else if(language.equals("Kiswahili"))
            {
                time=new Label("Wakati :");
            }
            else
            {
                time=new Label();
            }
            constraints=layout.createConstraint();
            constraints.setHorizontalSpan(5);
            this.addComponent(constraints,time);

            hours=new String[24];
            count=0;
            while(count<24)
            {
                String c;
                if(count<10)
                {
                    c=Integer.toString(0);
                    c=c+Integer.toString(count);
                }
                else
                {
                    c=Integer.toString(count);
                }
                hours[count]=c;
                count++;
            }
            hour=new MyComboBox(hours);
            hour.setListCellRenderer(new MyListCellRenderer(hours));
            this.addComponent(this.hour);

            Label forMin=new Label(":");
            constraints=layout.createConstraint();
            this.addComponent(forMin);

            mins=new String[60];
            count=0;
            while(count<60)
            {
                String c;
                if(count<10)
                {
                    c=Integer.toString(0);
                    c=c+Integer.toString(count);
                }
                else
                {
                    c=Integer.toString(count);
                }
                mins[count]=c;
                count++;
            }
            min=new MyComboBox(mins);
            min.setListCellRenderer(new MyListCellRenderer(mins));
            this.addComponent(this.min);

            Label forSec=new Label(":");
            constraints=layout.createConstraint();
            this.addComponent(forSec);

            sec=new MyComboBox(mins);
            sec.setListCellRenderer(new MyListCellRenderer(mins));
            this.addComponent(sec);
        }
        else if(dateTime==1)//time
        {
            Label time;
            if(language.equals("English"))
            {
                time=new Label("Time :");
            }
            else if(language.equals("Kiswahili"))
            {
                time=new Label("Wakati :");
            }
            else
            {
                time=new Label();
            }
            constraints=layout.createConstraint();
            constraints.setHorizontalSpan(5);
            this.addComponent(constraints,time);

            hours=new String[24];
            int count=0;
            while(count<24)
            {
                String c;
                if(count<10)
                {
                    c=Integer.toString(0);
                    c=c+Integer.toString(count);
                }
                else
                {
                    c=Integer.toString(count);
                }
                hours[count]=c;
                count++;
            }
            hour=new MyComboBox(hours);
            hour.setListCellRenderer(new MyListCellRenderer(hours));
            this.addComponent(this.hour);

            Label forMin=new Label(":");
            constraints=layout.createConstraint();
            this.addComponent(forMin);

            mins=new String[60];
            count=0;
            while(count<60)
            {
                String c;
                if(count<10)
                {
                    c=Integer.toString(0);
                    c=c+Integer.toString(count);
                }
                else
                {
                    c=Integer.toString(count);
                }
                mins[count]=c;
                count++;
            }
            min=new MyComboBox(mins);
            min.setListCellRenderer(new MyListCellRenderer(mins));
            this.addComponent(this.min);

            Label forSec=new Label(":");
            constraints=layout.createConstraint();
            this.addComponent(forSec);

            sec=new MyComboBox(mins);
            sec.setListCellRenderer(new MyListCellRenderer(mins));
            this.addComponent(sec);
            this.day=null;
            this.month=null;
            this.year=null;
        }
        else if(dateTime==0)//date
        {
            Label date;
            if(language.equals("English"))
            {
                date=new Label("Date :");
            }
            else if(language.equals("Kiswahili"))
            {
                date=new Label("Siku :");
            }
            else
            {
                date=new Label();
            }
            constraints=layout.createConstraint();
            constraints.setHorizontalSpan(5);
            this.addComponent(constraints,date);

            days=new String[31];
            int count=0;
            while(count<31)
            {
                days[count]=Integer.toString(count + 1);
                count++;
            }
            count=0;
            day=new MyComboBox(days);
            day.setListCellRenderer(new MyListCellRenderer(days));
            constraints=layout.createConstraint();
            constraints.setWidthPercentage(20);
            this.addComponent(constraints,this.day);

            Label forMonth=new Label("/");
            constraints=layout.createConstraint();
            constraints.setWidthPercentage(5);
            this.addComponent(constraints,forMonth);

            months=new String[12];
            if(language.equals("English"))
            {
                months[0]="January";
                months[1]="February";
                months[2]="March";
                months[3]="April";
                months[4]="May";
                months[5]="June";
                months[6]="July";
                months[7]="August";
                months[8]="September";
                months[9]="October";
                months[10]="November";
                months[11]="December";
            }
            else if(language.equals("Kiswahili"))
            {
                months[0]="Januari";
                months[1]="Februari";
                months[2]="Machi";
                months[3]="Aprili";
                months[4]="Mei";
                months[5]="Juni";
                months[6]="Julai";
                months[7]="Agosti";
                months[8]="Septemba";
                months[9]="Octoba";
                months[10]="Novemba";
                months[11]="Decemba";
            }
            else
            {
                int c=0;
                while(c<12)
                {
                    months[c]=null;
                    c++;
                }
            }
            month=new MyComboBox(months);
            month.setListCellRenderer(new MyListCellRenderer(months));
            constraints=layout.createConstraint();
            constraints.setWidthPercentage(33);
            this.addComponent(constraints,this.month);

            Label forYear=new Label("/");
            constraints=layout.createConstraint();
            constraints.setWidthPercentage(5);
            this.addComponent(constraints,forYear);

            count=1;
            int offSet=1929;
            years=new String[102];
            years[0]="Before 1930";
            while(count<101)
            {
                years[count]=Integer.toString(offSet+count);
                count++;
            }
            years[101]="After 2029";
            year=new MyComboBox(years);
            year.setListCellRenderer(new MyListCellRenderer(years));
            year.addActionListener(this);
            constraints=layout.createConstraint();
            constraints.setWidthPercentage(37);
            this.addComponent(constraints,this.year);
            this.hour=null;
            this.min=null;
            this.sec=null;
        }
        else
        {
            this.day=null;
            this.month=null;
            this.year=null;
            this.hour=null;
            this.min=null;
            this.sec=null;
        }//formating the b

        if(language.equals("English"))
        {
            this.previous=new Command("Previous");
            this.addCommand(previous);
            this.next=new Command("Next");
            this.addCommand(next);
        }
        else if(language.equals("Kiswahili"))
        {
            previous=new Command("Rudi Nyuma");
            this.addCommand(previous);
            next=new Command("Endelea");
            this.addCommand(next);
        }
        else
        {
            this.previous=null;
            this.next=null;
        }
        this.prevScreen=0;
        this.response=null;
    }

    /**
     *   FOR HEADER SCREEN
     * @param screenType
     * @param screenNo
     * @param introText
     * @param heading
     * @param language
     */
    public DynamicScreen(String screenType,int screenNo,String heading,String introText,String language)
    {
        this.setLayout(new BoxLayout(BoxLayout.Y_AXIS));
        this.addCommandListener(this);
        this.screenType=screenType;
        this.screenNo=screenNo;
        this.heading=new TextArea(heading);
        //format for heading
        this.heading.setEditable(false);
        this.heading.setFocusable(false);
        this.heading.getStyle().setBgTransparency(0);
        this.heading.getStyle().setBorder(null);

        this.addComponent(this.heading);
        this.introText=new TextArea(introText);
        //format for introtext
        this.introText.setEditable(false);
        this.introText.setFocusable(false);
        this.introText.getStyle().setBgTransparency(0);
        this.introText.getStyle().setBorder(null);
        this.addComponent(this.introText);
        this.addCommand(new Command(""));//add a phantom command so that the start command can be no the right
        if(language.equals("English"))
        {
            this.start=new Command("Start");
            this.addCommand(start);
        }
        else if(language.equals("Kiswahili"))
        {
            this.start=new Command("Anza");
            this.addCommand(start);
        }
        else
        {
            this.start=null;
        }
        data=null;
    }

    /**
     *   FOR INFO SCREEN
     * @param screenType
     * @param screenNo
     * @param text
     * @param language
     */
    public DynamicScreen(String screenType,int screenNo,String text,String language)
    {
        this.setLayout(new BoxLayout(BoxLayout.Y_AXIS));
        this.addCommandListener(this);
        this.screenType=screenType;
        this.screenNo=screenNo;
        this.text=new TextArea(text);
        //formatting for the textCount area
        this.text.setEditable(false);
        this.text.setFocusable(false);
        this.text.getStyle().setBgTransparency(0);
        this.text.getStyle().setBorder(null);

        this.addComponent(this.text);
        if(language.equals("English"))
        {
            previous=new Command("Previous");
            this.addCommand(previous);
            next=new Command("Next");
            this.addCommand(next);
        }
        else if(language.equals("Kiswahili"))
        {
            previous=new Command("Rudi Nyuma");
            this.addCommand(previous);
            next=new Command("Endelea");
            this.addCommand(next);
        }
        else
        {
            next=null;
            next=null;
        }
        this.prevScreen=0;
    }

    /**
     *   FOR LIST RESPONSE
     * @param screenType
     * @param screenNo
     * @param question
     * @param questionNo
     * @param listSize
     * @param responseLength
     * @param language
     */
    public DynamicScreen(String screenType,int screenNo,String question,int questionNo,int listSize,int responseLength,String language)
    {
        this.setLayout(new BoxLayout(BoxLayout.Y_AXIS));
        this.screenType=screenType;
        this.addCommandListener(this);
        this.screenNo=screenNo;
        this.question=new TextArea(question);
        //formatting for the textCount area
        this.question.setEditable(false);
        this.question.setFocusable(false);
        this.question.getStyle().setBgTransparency(0);
        this.question.getStyle().setBorder(null);

        this.addComponent(this.question);
        this.questionNo=questionNo;
        answers=new TextField[listSize];
        int count=0;
        while(count<listSize)
        {
            int textCount=count+1;
            String preText=Integer.toString(textCount)+". ";
            this.answers[count]=new TextField(preText);
            this.answers[count].setMaxSize(preText.length()+responseLength);
            this.answers[count].setCursorPosition(preText.length());
            this.addComponent(this.answers[count]);
            count++;
        }
        count=0;
        if(language.equals("English"))
        {
            this.previous=new Command("Previous");
            this.addCommand(previous);
            this.next=new Command("Next");
            this.addCommand(next);
        }
        else if(language.equals("Kiswahili"))
        {
            previous=new Command("Rudi Nyuma");
            this.addCommand(previous);
            next=new Command("Endelea");
            this.addCommand(next);
        }
        else
        {
            this.previous=null;
            this.next=null;
        }
        this.prevScreen=0;
        this.response=null;

    }

    /**
     *   FOR MULTISELECT
     * @param screenType
     * @param screenNo
     * @param wOS
     * @param question
     * @param choices
     * @param language
     * @param questionNo
     */
    public DynamicScreen(String screenType,int screenNo,String question,int questionNo,String[] choices,String language,int wOS)
            //the last two inputs give makes this constructor different from DATETIME
    {
        this.setLayout(new BoxLayout(BoxLayout.Y_AXIS));
        this.screenType=screenType;
        this.addCommandListener(this);
        this.screenNo=screenNo;
        this.question=new TextArea(question);
        //question formating
        this.question.setEditable(false);
        this.question.setFocusable(false);
        this.question.getStyle().setBgTransparency(0);
        this.question.getStyle().setBorder(null);

        this.addComponent(this.question);
        this.questionNo=questionNo;
        int choiceCount=choices.length;
        this.checkBChoices=new MyCheckBox[choiceCount];
        int count=0;
        while(count<choiceCount)
        {
            this.checkBChoices[count]=new MyCheckBox(choices[count]);
            this.addComponent(this.checkBChoices[count]);
            count++;
        }
        if(wOS==1 && language.equals("English"))
        {
            this.checkBOther=new MyCheckBox("Other");
            this.checkBOther.addActionListener(this);
            this.addComponent(this.checkBOther);
            this.specify=new TextField("Specify here");
            this.specify.setEditable(false);
            this.addComponent(this.specify);

        }
        else if(wOS==1 && language.equals("Kiswahili"))
        {
            this.checkBOther=new MyCheckBox("Nyingine");
            this.checkBOther.addActionListener(this);
            this.addComponent(this.checkBOther);
            this.specify=new TextField("Taja hapa");
            this.specify.setEditable(false);
            this.addComponent(this.specify);
        }
        else//if wOS ==0
        {
            this.checkBOther=null;
            this.specify=null;
        }

        if(language.equals("English"))
        {
            this.previous=new Command("Previous");
            this.addCommand(previous);
            this.next=new Command("Next");
            this.addCommand(next);
        }
        else if(language.equals("Kiswahili"))
        {
            previous=new Command("Rudi Nyuma");
            this.addCommand(previous);
            next=new Command("Endelea");
            this.addCommand(next);
        }
        else
        {
            this.previous=null;
            this.next=null;
        }

        prevScreen=0;
        response=null;
    }

    /**
     *   FOR OPEN ENDED
     * @param screenType
     * @param questionNo
     * @param screenNo
     * @param language
     * @param responseLength
     * @param question
     */
    public DynamicScreen(String screenType,int screenNo,String question,int questionNo,int responseLength,String language)
    {
        this.setLayout(new BoxLayout(BoxLayout.Y_AXIS));
        this.screenNo=screenNo;
        this.screenType=screenType;
        this.addCommandListener(this);
        this.question=new TextArea(question);
        //formatting for the text area
        this.question.setEditable(false);
        this.question.setFocusable(false);
        this.question.getStyle().setBgTransparency(0);
        this.question.getStyle().setBorder(null);

        this.addComponent(this.question);
        this.questionNo=questionNo;
        this.answer=new TextArea("", responseLength);
        this.answer.setRows(4);
        this.addComponent(this.answer);
        if(language.equals("English"))
        {
            this.previous=new Command("Previous");
            this.addCommand(previous);
            this.next=new Command("Next");
            this.addCommand(next);
        }
        else if(language.equals("Kiswahili"))
        {
            previous=new Command("Rudi Nyuma");
            this.addCommand(previous);
            next=new Command("Endelea");
            this.addCommand(next);
        }
        else
        {
            this.previous=null;
            this.next=null;
        }
        this.prevScreen=0;
        this.response=null;

    }

    /**
     *   FOR RANKING
     * @param screenType
     * @param screenNo
     * @param listSize
     * @param question
     * @param questionNo
     * @param ranks
     * @param language
     */
    public DynamicScreen(String screenType,int screenNo,String question,int questionNo,String[] ranks,int listSize,String language)
    {
        this.setLayout(new BoxLayout(BoxLayout.Y_AXIS));
        this.screenNo=screenNo;
        this.screenType=screenType;
        this.addCommandListener(this);
        this.questionNo=questionNo;
        this.question=new TextArea(question);
        //formatting for the text area
        this.question.setEditable(false);
        this.question.setFocusable(false);
        this.question.getStyle().setBgTransparency(0);
        this.question.getStyle().setBorder(null);

        this.addComponent(this.question);
        this.ranks=ranks;
        positions=new MyComboBox[listSize];
        int count=0;
        while(count<listSize)
        {
            positions[count]=new MyComboBox(ranks);
            positions[count].setListCellRenderer(new MyListCellRenderer(ranks));
            this.addComponent(this.positions[count]);
            count++;
        }
        count=0;
        if(language.equals("English"))
        {
            this.previous=new Command("Previous");
            this.addCommand(previous);
            this.next=new Command("Next");
            this.addCommand(next);
        }
        else if(language.equals("Kiswahili"))
        {
            previous=new Command("Rudi Nyuma");
            this.addCommand(previous);
            next=new Command("Endelea");
            this.addCommand(next);
        }
        else
        {
            this.previous=null;
            this.next=null;
        }
        this.prevScreen=0;
        this.response=null;

    }

    /**
     *   FOR SINGLE SELECT
     * @param screenType
     * @param questionNo
     * @param question
     * @param screenNo
     * @param choices
     * @param wOS
     * @param language
     * @param nextScreens
     */
    public DynamicScreen(String screenType,int screenNo,String question,int questionNo,String[] choices,int[] nextScreens,String language,int wOS)//next screen includes other specify next screen
    {
        this.setLayout(new BoxLayout(BoxLayout.Y_AXIS));
        this.screenNo=screenNo;//found in the superclass dynamicScreen
        this.screenType=screenType;
        this.addCommandListener(this);
        this.question=new TextArea(question);
        //question formating
        this.question.setEditable(false);
        this.question.setFocusable(false);
        this.question.getStyle().setBgTransparency(0);
        this.question.getStyle().setBorder(null);

        this.addComponent(this.question);
        this.questionNo=questionNo;
        int choiceCount=choices.length;
        this.eachChoice=new MyRadioButton[choiceCount];
        this.buttonGChoices=new ButtonGroup();
        int count=0;
        while(count<choiceCount)
        {
            this.eachChoice[count]=new MyRadioButton(choices[count]);
            this.buttonGChoices.add(this.eachChoice[count]);
            this.addComponent(eachChoice[count]);
            count++;
        }
        count=0;
        if(wOS==1 && language.equals("English"))
        {
            this.radioBOther=new MyRadioButton("Other");
            this.radioBOther.addActionListener(this);
            this.buttonGChoices.add(this.radioBOther);
            this.addComponent(this.radioBOther);
            this.specify=new TextField("Specify here");
            this.specify.setEditable(false);
            this.addComponent(this.specify);

        }
        else if(wOS==1 && language.equals("Kiswahili"))
        {
            this.radioBOther=new MyRadioButton("Nyingine");
            //this.radioBOther.addActionListener(this);
            this.buttonGChoices.add(radioBOther);
            this.addComponent(this.radioBOther);
            this.specify=new TextField("Taja hapa");
            this.specify.setEditable(false);
            this.addComponent(this.specify);
        }
        else//if wOS==0 or radioBOther
        {
            this.radioBOther=null;
            this.specify=null;
        }
        if(language.equals("English"))
        {
            previous=new Command("Previous");
            this.addCommand(previous);
            next=new Command("Next");
            this.addCommand(next);
        }
        else if(language.equals("Kiswahili"))
        {
            previous=new Command("Rudi Nyuma");
            this.addCommand(previous);
            next=new Command("Endelea");
            this.addCommand(next);
        }
        else
        {
            next=null;
            next=null;
        }
        prevScreen=0;
        response=null;
        this.nextScreens=nextScreens;//an array of next screen depending on choice made

    }

    /**
     *   FOR FOOTER SCREEN
     * @param language
     */
    public DynamicScreen(String language)
    {
        this.setLayout(new BoxLayout(BoxLayout.Y_AXIS));
        this.addCommandListener(this);
        this.screenType="footer";
        String textContent=null;
        if(language.equals("English"))
        {
            textContent="YOU HAVE FINISHED!"
                    + " - To submit your responses, press Submit"
                    + " - Otherwise press Back to go to the previous screen";
            this.text=new TextArea(textContent);
             //format for introtext
            this.text.setEditable(false);
            this.text.setFocusable(false);
            this.text.getStyle().setBgTransparency(0);
            this.text.getStyle().setBorder(null);
            this.addComponent(this.text);
            this.previous=new Command("Back");
            this.addCommand(previous);
            this.next=new Command("Submit");
            this.addCommand(next);
        }
        else if(language.equals("Kiswahili"))
        {
            textContent="UMEMALIZA!"
                    + " - Kuwasilisha majibu yako kwenye Mtandao, bonyeza Wasilisha"
                    + " - Laa sivyo bonyeza Rudi Nyuma, utarudishwa kwa ukurasa uliopita";
            this.text=new TextArea(textContent);
            //format for introtext
            this.text.setEditable(false);
            this.text.setFocusable(false);
            this.text.getStyle().setBgTransparency(0);
            this.text.getStyle().setBorder(null);
            this.addComponent(this.text);
            this.previous=new Command("Rudi Nyuma");
            this.addCommand(previous);
            this.next=new Command("Wasilisha");
            this.addCommand(next);
        }

    }
    //end constructor overloading!!

    //start other methods
    public void setData(GlobalData data)
    {
        this.data=data;
    }

    private void setPrevScreen(int prevScreen)
    {
        this.prevScreen=prevScreen;
    }
    public void actionPerformed(ActionEvent evt)
    {
        if(screenType.equals("Header"))
        {
            if(evt.getCommand()==start)
            {
                data.appScreens[screenNo+1].setData(data);
                data.appScreens[screenNo+1].setPrevScreen(this.screenNo);//set preScreen of next screen to this screenno
                data.appScreens[screenNo+1].show();
            }
        }
        else if(screenType.equals("Information Screen"))
        {
            if(evt.getCommand()==previous)
            {
                data.appScreens[prevScreen].setData(data);
                data.appScreens[prevScreen].show();
            }
            else if(evt.getCommand()==next)
            {
                data.appScreens[screenNo+1].setData(data);
                data.appScreens[screenNo+1].setPrevScreen(this.screenNo);
                data.appScreens[screenNo+1].show();
            }
        }
        else if(screenType.equals("Single selection, multiple choice Query"))
        {
            if(evt.getCommand()==previous)
            {
                //get which radio is selected
                int count=0;
                String ans=null;
                int flag=0;//checks if a choice has been selected
                while(count<eachChoice.length)
                {
                    if(eachChoice[count].isSelected()==true)
                    {
                        ans=eachChoice[count].getText();
                        flag=1;
                    }
                    count++;
                }
                count=0;
                if(radioBOther!=null && flag==0 && radioBOther.isSelected())
                {
                    ans=this.specify.getText();
                    flag=1;
                }

                if(flag==1)//a choice has been selected
                {
                    this.response=new Response();
                    this.response.setQuestion(this.question.getText(), questionNo);
                    String[] ansInArray=new String[1];
                    ansInArray[0]=ans;
                    this.response.setResponses(ansInArray);

                    //check global responses
                    if(data.responses==null)//this is the first question
                    {
                        Response[] newResponses=new Response[1];//create the array
                        newResponses[0]=new Response();
                        newResponses[0]=this.response;//add the response
                        data.responses=newResponses;//update global responses
                    }
                    else if (data.responses.length<=this.questionNo && data.responses!=null)//first time
                    {
                        Response[] newResponses=new Response[questionNo+1];//create array with one extra response
                        count=0;
                        while(count<data.responses.length)
                        {
                            newResponses[count]=data.responses[count];//populate new array with what is in global responses
                            count++;
                        }
                        while(count<questionNo)
                        {
                            newResponses[count]=null;
                            count++;
                        }
                        count=0;
                        newResponses[questionNo]=this.response;//set the extra response
                        data.responses=newResponses;//update global responses
                    }
                    else if(data.responses.length>this.questionNo)//this question has been answered before
                    {
                        data.responses[questionNo]=this.response;
                    }
                }
                data.appScreens[prevScreen].setData(data);
                data.appScreens[prevScreen].show();

            }
            else if(evt.getCommand()==next)
            {
                //get which radio is selected
                int count=0;
                String ans=null;
                int flag=0;//checks if a choice has been selected
                int selectedRadio=0;
                while(count<eachChoice.length)
                {
                    if(eachChoice[count].isSelected()==true)
                    {
                        ans=eachChoice[count].getText();
                        selectedRadio=count;
                        flag=1;
                    }
                    count++;
                }
                count=0;
                if(radioBOther!=null && flag==0 && radioBOther.isSelected())//restore
                {
                    ans=specify.getText();
                    selectedRadio=eachChoice.length;//the last element in the next screen array which is the next screen for other specify
                    //what will happen if other is chosen
                    flag=1;
                }

                if(flag==1)//a choice has been selected
                {
                    this.response=new Response();
                    this.response.setQuestion(this.question.getText(), questionNo);
                    String[] ansInArray=new String[1];
                    ansInArray[0]=ans;
                    this.response.setResponses(ansInArray);

                    //check global responses
                    if(data.responses==null)//this is the first question
                    {
                        Response[] newResponses=new Response[1];//create the array
                        newResponses[0]=new Response();
                        newResponses[0]=this.response;//add the response
                        data.responses=newResponses;//update global responses
                    }
                    else if (data.responses.length<=this.questionNo && data.responses!=null)//first time
                    {
                        Response[] newResponses=new Response[questionNo+1];//create array with one extra response
                        count=0;
                        while(count<data.responses.length)
                        {
                            newResponses[count]=data.responses[count];//populate new array with what is in global responses
                            count++;
                        }
                        while(count<questionNo)
                        {
                            newResponses[count]=null;
                            count++;
                        }
                        count=0;
                        newResponses[questionNo]=this.response;//set the extra response
                        data.responses=newResponses;//update global responses
                    }
                    else if(data.responses.length>this.questionNo)//this question has been answered before
                    {
                        data.responses[questionNo]=this.response;
                    }
                        data.appScreens[nextScreens[selectedRadio]].setData(data);//each radio button has a next screen
                        data.appScreens[nextScreens[selectedRadio]].setPrevScreen(this.screenNo);
                        data.appScreens[nextScreens[selectedRadio]].show();
                }

            }
            if(evt.getSource()==this.radioBOther)
            {
                this.specify.setText("-");
                this.specify.setEditable(true);
                this.specify.setCursorPosition(1);
            }
        }
        else if(screenType.equals("Multiple selection, multiple choice Query"))
        {
            if(evt.getCommand()==previous)
            {
                //get which checkbox is selected
                int count=0;
                int howMany=0;
                while(count<this.checkBChoices.length)//check for selected check boxes
                {
                    if(this.checkBChoices[count].isSelected()==true)
                    {
                        howMany++;
                    }
                    count++;
                }
                if(checkBOther!=null && checkBOther.isSelected()==true)
                {
                    howMany++;
                }
                count=0;

                //if(howMany>0)//if more than 0 checkboxes have been selected
                //{
                    String[] selectedCheckB=new String[howMany];
                    count=0;
                    while(count<howMany)
                    {
                        selectedCheckB[count]=null;
                        count++;
                    }
                    count=0;
                    int pointer=0;
                    while(count<this.checkBChoices.length)//check for selected check boxes
                    {
                        if(this.checkBChoices[count].isSelected()==true)
                        {
                            selectedCheckB[pointer]=this.checkBChoices[count].getText();
                            pointer++;
                        }
                        count++;
                    }
                    if(checkBOther!=null && checkBOther.isSelected()==true)
                    {
                        selectedCheckB[pointer]=this.specify.getText();
                    }
                    count=0;

                    //initialize response var
                    this.response=new Response();
                    this.response.setQuestion(this.question.getText(), questionNo);
                    this.response.setResponses(selectedCheckB);

                     //check global responses
                    if(data.responses==null)//this is the first question
                    {
                        Response[] newResponses=new Response[1];//create the array
                        newResponses[0]=new Response();
                        newResponses[0]=this.response;//add the response
                        data.responses=newResponses;//update global responses
                    }
                    else if (data.responses.length<=this.questionNo && data.responses!=null)//first time
                    {
                        Response[] newResponses=new Response[questionNo+1];//create array with one extra response
                        count=0;
                        while(count<data.responses.length)
                        {
                            newResponses[count]=data.responses[count];//populate new array with what is in global responses
                            count++;
                        }
                        while(count<questionNo)
                        {
                            newResponses[count]=null;
                            count++;
                        }
                        count=0;
                        newResponses[questionNo]=this.response;//set the extra response
                        data.responses=newResponses;//update global responses
                    }
                    else if(data.responses.length>this.questionNo)//this question has been answered before
                    {
                        data.responses[questionNo]=this.response;
                    }

                    data.appScreens[prevScreen].setData(data);
                    data.appScreens[prevScreen].show();
                //}

            }
            else if(evt.getCommand()==next)
            {
                //get which checkbox is selected
                int count=0;
                int howMany=0;
                while(count<this.checkBChoices.length)//check for selected check boxes
                {
                    if(this.checkBChoices[count].isSelected()==true)
                    {
                        howMany++;
                    }
                    count++;
                }
                if(checkBOther!=null && checkBOther.isSelected()==true)
                {
                    howMany++;
                }
                count=0;

                //if(howMany>0)//if more than 0 checkboxes have been selected
                //{
                    String[] selectedCheckB=new String[howMany];
                    count=0;
                    while(count<howMany)
                    {
                        selectedCheckB[count]=null;
                        count++;
                    }
                    count=0;
                    int pointer=0;
                    while(count<this.checkBChoices.length)//check for selected check boxes
                    {
                        if(this.checkBChoices[count].isSelected()==true)
                        {
                            selectedCheckB[pointer]=this.checkBChoices[count].getText();
                            pointer++;
                        }
                        count++;
                    }
                    if(checkBOther!=null && checkBOther.isSelected()==true)
                    {
                        selectedCheckB[pointer]=this.specify.getText();
                    }
                    count=0;

                    //initialize response var
                    this.response=new Response();
                    this.response.setQuestion(this.question.getText(), questionNo);
                    this.response.setResponses(selectedCheckB);

                     //check global responses
                    if(data.responses==null)//this is the first question
                    {
                        Response[] newResponses=new Response[1];//create the array
                        newResponses[0]=new Response();
                        newResponses[0]=this.response;//add the response
                        data.responses=newResponses;//update global responses
                    }
                    else if (data.responses.length<=this.questionNo && data.responses!=null)//first time
                    {
                        Response[] newResponses=new Response[questionNo+1];//create array with one extra response
                        count=0;
                        while(count<data.responses.length)
                        {
                            newResponses[count]=data.responses[count];//populate new array with what is in global responses
                            count++;
                        }
                        while(count<questionNo)
                        {
                            newResponses[count]=null;
                            count++;
                        }
                        count=0;
                        newResponses[questionNo]=this.response;//set the extra response
                        data.responses=newResponses;//update global responses
                    }
                    else if(data.responses.length>this.questionNo)//this question has been answered before
                    {
                        data.responses[questionNo]=this.response;
                    }

                    data.appScreens[screenNo+1].setData(data);
                    data.appScreens[screenNo+1].setPrevScreen(this.screenNo);
                    data.appScreens[screenNo+1].show();
                //}
            }
            if(evt.getSource()==this.checkBOther)
            {
                this.specify.setText("-");
                this.specify.setEditable(true);
                this.specify.setCursorPosition(1);
            }
        }
        else if(screenType.equals("List response Query"))
        {
            if(evt.getCommand()==previous)
            {
                //get text fields
                int count=0;
                String[] ans=new String[answers.length];
                while(count<answers.length)//initialize ans
                {
                    ans[count]=null;
                    count++;
                }
                count=0;
                while(count<answers.length)//transfer text from textfields to string[]
                {
                    ans[count]=answers[count].getText();
                    count++;
                }
                count=0;

                //initialize response var
                this.response=new Response();
                this.response.setQuestion(question.getText(), questionNo);
                this.response.setResponses(ans);

                //check global responses
                    if(data.responses==null)//this is the first question
                    {
                        Response[] newResponses=new Response[1];//create the array
                        newResponses[0]=new Response();
                        newResponses[0]=this.response;//add the response
                        data.responses=newResponses;//update global responses
                    }
                    else if (data.responses.length<=this.questionNo && data.responses!=null)//first time
                    {
                        Response[] newResponses=new Response[questionNo+1];//create array with one extra response
                        count=0;
                        while(count<data.responses.length)
                        {
                            newResponses[count]=data.responses[count];//populate new array with what is in global responses
                            count++;
                        }
                        while(count<questionNo)
                        {
                            newResponses[count]=null;
                            count++;
                        }
                        count=0;
                        newResponses[questionNo]=this.response;//set the extra response
                        data.responses=newResponses;//update global responses
                    }
                    else if(data.responses.length>this.questionNo)//this question has been answered before
                    {
                        data.responses[questionNo]=this.response;
                    }

                data.appScreens[prevScreen].setData(data);
                data.appScreens[prevScreen].show();
            }
            else if(evt.getCommand()==next)
            {
                //get text fields
                int count=0;
                String[] ans=new String[answers.length];
                while(count<answers.length)//initialize ans
                {
                    ans[count]=null;
                    count++;
                }
                count=0;
                while(count<answers.length)//transfer text from textfields to string[]
                {
                    ans[count]=answers[count].getText();
                    count++;
                }
                count=0;

                //initialize response var
                this.response=new Response();
                this.response.setQuestion(question.getText(), questionNo);
                this.response.setResponses(ans);

                //check global responses
                    if(data.responses==null)//this is the first question
                    {
                        Response[] newResponses=new Response[1];//create the array
                        newResponses[0]=new Response();
                        newResponses[0]=this.response;//add the response
                        data.responses=newResponses;//update global responses
                    }
                    else if (data.responses.length<=this.questionNo && data.responses!=null)//first time
                    {
                        Response[] newResponses=new Response[questionNo+1];//create array with one extra response
                        count=0;
                        while(count<data.responses.length)
                        {
                            newResponses[count]=data.responses[count];//populate new array with what is in global responses
                            count++;
                        }
                        while(count<questionNo)
                        {
                            newResponses[count]=null;
                            count++;
                        }
                        count=0;
                        newResponses[questionNo]=this.response;//set the extra response
                        data.responses=newResponses;//update global responses
                    }
                    else if(data.responses.length>this.questionNo)//this question has been answered before
                    {
                        data.responses[questionNo]=this.response;
                    }

                data.appScreens[screenNo+1].setData(data);
                data.appScreens[screenNo+1].setPrevScreen(this.screenNo);
                data.appScreens[screenNo+1].show();
            }
        }
        else if(screenType.equals("Open ended Question"))
        {
            if(evt.getCommand()==previous)
            {
                //get text area
                String[] ansInArray=new String[1];
                ansInArray[0]=answer.getText();//input into string[] ans

                //initialize response
                this.response=new Response();
                this.response.setQuestion(this.question.getText(), questionNo);
                this.response.setResponses(ansInArray);

                //check global responses
                int count=0;
                    if(data.responses==null)//this is the first question
                    {
                        Response[] newResponses=new Response[1];//create the array
                        newResponses[0]=new Response();
                        newResponses[0]=this.response;//add the response
                        data.responses=newResponses;//update global responses
                    }
                    else if (data.responses.length<=this.questionNo && data.responses!=null)//first time
                    {
                        Response[] newResponses=new Response[questionNo+1];//create array with one extra response
                        count=0;
                        while(count<data.responses.length)
                        {
                            newResponses[count]=data.responses[count];//populate new array with what is in global responses
                            count++;
                        }
                        while(count<questionNo)
                        {
                            newResponses[count]=null;
                            count++;
                        }
                        count=0;
                        newResponses[questionNo]=this.response;//set the extra response
                        data.responses=newResponses;//update global responses
                    }
                    else if(data.responses.length>this.questionNo)//this question has been answered before
                    {
                        data.responses[questionNo]=this.response;
                    }

                data.appScreens[prevScreen].setData(data);
                data.appScreens[prevScreen].show();
            }
            else if(evt.getCommand()==next)
            {
                //get text area
                String[] ansInArray=new String[1];
                ansInArray[0]=answer.getText();//input into string[] ans

                //initialize response
                this.response=new Response();
                this.response.setQuestion(this.question.getText(), questionNo);
                this.response.setResponses(ansInArray);

                //check global responses
                int count=0;
                    if(data.responses==null)//this is the first question
                    {
                        Response[] newResponses=new Response[1];//create the array
                        newResponses[0]=new Response();
                        newResponses[0]=this.response;//add the response
                        data.responses=newResponses;//update global responses
                    }
                    else if (data.responses.length<=this.questionNo && data.responses!=null)//first time
                    {
                        Response[] newResponses=new Response[questionNo+1];//create array with one extra response
                        count=0;
                        while(count<data.responses.length)
                        {
                            newResponses[count]=data.responses[count];//populate new array with what is in global responses
                            count++;
                        }
                        while(count<questionNo)
                        {
                            newResponses[count]=null;
                            count++;
                        }
                        count=0;
                        newResponses[questionNo]=this.response;//set the extra response
                        data.responses=newResponses;//update global responses
                    }
                    else if(data.responses.length>this.questionNo)//this question has been answered before
                    {
                        data.responses[questionNo]=this.response;
                    }

                data.appScreens[screenNo+1].setData(data);
                data.appScreens[screenNo+1].setPrevScreen(this.screenNo);
                data.appScreens[screenNo+1].show();
            }
        }
        else if(screenType.equals("Ranking Query"))
        {
            if(evt.getCommand()==previous)
            {
                //get selected rank for each postion
                int count=0;
                String[] comboBAns=new String[positions.length];
                while(count<positions.length)
                {
                    comboBAns[count]=null;
                    count++;
                }
                count=0;
                while(count<positions.length)//not sure about this
                {
                    comboBAns[count]=positions[count].getSelectedItem().toString();
                    count++;
                }
                count=0;

                //initilize response var
                this.response=new Response();
                this.response.setQuestion(this.question.getText(), questionNo);
                this.response.setResponses(comboBAns);

                //check global responses
                    if(data.responses==null)//this is the first question
                    {
                        Response[] newResponses=new Response[1];//create the array
                        newResponses[0]=new Response();
                        newResponses[0]=this.response;//add the response
                        data.responses=newResponses;//update global responses
                    }
                    else if (data.responses.length<=this.questionNo && data.responses!=null)//first time
                    {
                        Response[] newResponses=new Response[questionNo+1];//create array with one extra response
                        count=0;
                        while(count<data.responses.length)
                        {
                            newResponses[count]=data.responses[count];//populate new array with what is in global responses
                            count++;
                        }
                        while(count<questionNo)
                        {
                            newResponses[count]=null;
                            count++;
                        }
                        count=0;
                        newResponses[questionNo]=this.response;//set the extra response
                        data.responses=newResponses;//update global responses
                    }
                    else if(data.responses.length>this.questionNo)//this question has been answered before
                    {
                        data.responses[questionNo]=this.response;
                    }

                data.appScreens[prevScreen].setData(data);
                data.appScreens[prevScreen].show();
            }
            else if(evt.getCommand()==next)
            {
                //get selected rank for each postion
                int count=0;
                String[] comboBAns=new String[positions.length];
                while(count<positions.length)
                {
                    comboBAns[count]=null;
                    count++;
                }
                count=0;
                while(count<positions.length)//not sure about this
                {
                    comboBAns[count]=positions[count].getSelectedItem().toString();
                    count++;
                }
                count=0;

                //initilize response var
                this.response=new Response();
                this.response.setQuestion(this.question.getText(), questionNo);
                this.response.setResponses(comboBAns);

                //check global responses
                    if(data.responses==null)//this is the first question
                    {
                        Response[] newResponses=new Response[1];//create the array
                        newResponses[0]=new Response();
                        newResponses[0]=this.response;//add the response
                        data.responses=newResponses;//update global responses
                    }
                    else if (data.responses.length<=this.questionNo && data.responses!=null)//first time
                    {
                        Response[] newResponses=new Response[questionNo+1];//create array with one extra response
                        count=0;
                        while(count<data.responses.length)
                        {
                            newResponses[count]=data.responses[count];//populate new array with what is in global responses
                            count++;
                        }
                        while(count<questionNo)
                        {
                            newResponses[count]=null;
                            count++;
                        }
                        count=0;
                        newResponses[questionNo]=this.response;//set the extra response
                        data.responses=newResponses;//update global responses
                    }
                    else if(data.responses.length>this.questionNo)//this question has been answered before
                    {
                        data.responses[questionNo]=this.response;
                    }

                data.appScreens[screenNo+1].setData(data);
                data.appScreens[screenNo+1].setPrevScreen(this.screenNo);
                data.appScreens[screenNo+1].show();
            }
        }
        else if(screenType.equals("DateTime Query"))
        {
            if(evt.getCommand()==previous)
            {
                if(dateTime==0)//date
                {
                    //check consistency
                    String yearData=year.getSelectedItem().toString();
                    String dayData=day.getSelectedItem().toString();
                    String monthData=month.getSelectedItem().toString();
                    if(monthData.equals("September") || monthData.equals("April") || monthData.equals("June")|| monthData.equals("November")|| monthData.equals("Septemba")|| monthData.equals("Aprili") || monthData.equals("Juni") || monthData.equals("Novemba"))
                    {
                        if(dayData.equals("31"))
                        {
                            dateFlag=1;
                            //day.setSelectedIndex(29);
                            Dialog d=new Dialog("Date error");
                            d.setDialogType(Dialog.TYPE_WARNING);
                            if(language.equals("English"))
                            {
                                d.show("Inconsistent date", "Change day on the date", "ok", null);
                            }
                            else if(language.equals("Kiswahili"))
                            {
                                d.show("Tarehe mbovu", "Badilisha siku", "ok", null);
                            }
                        }
                        else
                        {
                            dateFlag=0;
                        }
                    }
                    else if(monthData.equals("February") || monthData.equals("Februari"))
                    {
                        int yr=0;
                        try
                        {
                            yr = Integer.parseInt(yearData);
                        }
                        catch(Exception e)
                        {

                        }
                        int mod=yr%4;//check if year is divisible by 4 if parseInt failed then it was either the first or last choice mod will be 0
                        if(mod==0)//leap year
                        {
                            if(dayData.equals("30") || dayData.equals("31"))
                            {
                                dateFlag=1;
                                //day.setSelectedIndex(28);//max days in 29
                                Dialog d=new Dialog("Date error");
                                d.setDialogType(Dialog.TYPE_WARNING);
                                if(language.equals("English"))
                                {
                                    d.show("Inconsistent date", "Change day on the date", "ok", null);
                                }
                                else if(language.equals("Kiswahili"))
                                {
                                    d.show("Tarehe mbovu", "Badilisha siku kwenye tarehe", "ok", null);
                                }
                            }
                            else
                            {
                                dateFlag=0;
                            }
                        }
                        else
                        {
                            if(dayData.equals("30") || dayData.equals("31") || dayData.equals("29"))
                            {
                                dateFlag=1;
                                //day.setSelectedIndex(27);//max days in 28
                                Dialog d=new Dialog("Date error");
                                d.setDialogType(Dialog.TYPE_WARNING);
                                if(language.equals("English"))
                                {
                                    d.show("Inconsistent date", "Change day on the date", "ok", null);
                                }
                                else if(language.equals("Kiswahili"))
                                {
                                    d.show("Tarehe mbovu", "Badilisha siku kwenye tarehe", "ok", null);
                                }
                            }
                            else
                            {
                                dateFlag=0;
                            }
                        }
                    }


                    String[] ans=new String[1];
                    ans[0]=day.getSelectedItem().toString()+"-"+month.getSelectedItem().toString()+"-"+year.getSelectedItem().toString();
                    this.response=new Response();
                    this.response.setQuestion(this.question.getText(), questionNo);
                    this.response.setResponses(ans);
                    
                    //check global responses
                    int count=0;
                    if(data.responses==null)//this is the first question
                    {
                        Response[] newResponses=new Response[1];//create the array
                        newResponses[0]=new Response();
                        newResponses[0]=this.response;//add the response
                        data.responses=newResponses;//update global responses
                    }
                    else if (data.responses.length<=this.questionNo && data.responses!=null)//first time
                    {
                        Response[] newResponses=new Response[questionNo+1];//create array with one extra response
                        count=0;
                        while(count<data.responses.length)
                        {
                            newResponses[count]=data.responses[count];//populate new array with what is in global responses
                            count++;
                        }
                        while(count<questionNo)
                        {
                            newResponses[count]=null;
                            count++;
                        }
                        count=0;
                        newResponses[questionNo]=this.response;//set the extra response
                        data.responses=newResponses;//update global responses
                    }
                    else if(data.responses.length>this.questionNo)//this question has been answered before
                    {
                        data.responses[questionNo]=this.response;
                    }
                    if(dateFlag!=1)
                    {
                        data.appScreens[prevScreen].setData(data);
                        data.appScreens[prevScreen].show();
                    }
                }
                else if(dateTime==1)//time
                {
                    String[] ans=new String[1];
                    ans[0]=hour.getSelectedItem().toString()+":"+min.getSelectedItem().toString()+":"+sec.getSelectedItem().toString();
                    this.response=new Response();
                    this.response.setQuestion(this.question.getText(), questionNo);
                    this.response.setResponses(ans);

                    //check global responses
                    int count=0;
                    if(data.responses==null)//this is the first question
                    {
                        Response[] newResponses=new Response[1];//create the array
                        newResponses[0]=new Response();
                        newResponses[0]=this.response;//add the response
                        data.responses=newResponses;//update global responses
                    }
                    else if (data.responses.length<=this.questionNo && data.responses!=null)//first time
                    {
                        Response[] newResponses=new Response[questionNo+1];//create array with one extra response
                        count=0;
                        while(count<data.responses.length)
                        {
                            newResponses[count]=data.responses[count];//populate new array with what is in global responses
                            count++;
                        }
                        while(count<questionNo)
                        {
                            newResponses[count]=null;
                            count++;
                        }
                        count=0;
                        newResponses[questionNo]=this.response;//set the extra response
                        data.responses=newResponses;//update global responses
                    }
                    else if(data.responses.length>this.questionNo)//this question has been answered before
                    {
                        data.responses[questionNo]=this.response;
                    }

                    data.appScreens[prevScreen].setData(data);
                    data.appScreens[prevScreen].show();
                }
                else if(dateTime==2)//datetime
                {
                    //check consistency
                    String yearData=year.getSelectedItem().toString();
                    String dayData=day.getSelectedItem().toString();
                    String monthData=month.getSelectedItem().toString();
                    if(monthData.equals("September") || monthData.equals("April") || monthData.equals("June")|| monthData.equals("November")|| monthData.equals("Septemba")|| monthData.equals("Aprili") || monthData.equals("Juni") || monthData.equals("Novemba"))
                    {
                        if(dayData.equals("31"))
                        {
                            dateFlag=1;
                            //day.setSelectedIndex(29);
                            Dialog d=new Dialog("Date error");
                            d.setDialogType(Dialog.TYPE_WARNING);
                            if(language.equals("English"))
                            {
                                d.show("Inconsistent date", "Change day on the date", "ok", null);
                            }
                            else if(language.equals("Kiswahili"))
                            {
                                d.show("Tarehe mbovu", "Badilisha siku", "ok", null);
                            }
                        }
                        else
                        {
                            dateFlag=0;
                        }
                    }
                    else if(monthData.equals("February") || monthData.equals("Februari"))
                    {
                        int yr=0;
                        try
                        {
                            yr = Integer.parseInt(yearData);
                        }
                        catch(Exception e)
                        {

                        }
                        int mod=yr%4;//check if year is divisible by 4 if parseInt failed then it was either the first or last choice mod will be 0
                        if(mod==0)//leap year
                        {
                            if(dayData.equals("30") || dayData.equals("31"))
                            {
                                dateFlag=1;
                                //day.setSelectedIndex(28);//max days in 29
                                Dialog d=new Dialog("Date error");
                                d.setDialogType(Dialog.TYPE_WARNING);
                                if(language.equals("English"))
                                {
                                    d.show("Inconsistent date", "Change day on the date", "ok", null);
                                }
                                else if(language.equals("Kiswahili"))
                                {
                                    d.show("Tarehe mbovu", "Badilisha siku kwenye tarehe", "ok", null);
                                }
                            }
                            else
                            {
                                dateFlag=0;
                            }
                        }
                        else
                        {
                            if(dayData.equals("30") || dayData.equals("31") || dayData.equals("29"))
                            {
                                dateFlag=1;
                                //day.setSelectedIndex(27);//max days in 28
                                Dialog d=new Dialog("Date error");
                                d.setDialogType(Dialog.TYPE_WARNING);
                                if(language.equals("English"))
                                {
                                    d.show("Inconsistent date", "Change day on the date", "ok", null);
                                }
                                else if(language.equals("Kiswahili"))
                                {
                                    d.show("Tarehe mbovu", "Badilisha siku kwenye tarehe", "ok", null);
                                }
                            }
                            else
                            {
                                dateFlag=0;
                            }
                        }
                    }


                    String[] ans=new String[1];
                    ans[0]=day.getSelectedItem().toString()+"-"+month.getSelectedItem().toString()+"-"+year.getSelectedItem().toString()+" ";
                    ans[0]=ans[0]+hour.getSelectedItem().toString()+":"+min.getSelectedItem().toString()+":"+sec.getSelectedItem().toString();
                    this.response=new Response();
                    this.response.setQuestion(this.question.getText(), questionNo);
                    this.response.setResponses(ans);

                    //check global responses
                    int count=0;
                    if(data.responses==null)//this is the first question
                    {
                        Response[] newResponses=new Response[1];//create the array
                        newResponses[0]=new Response();
                        newResponses[0]=this.response;//add the response
                        data.responses=newResponses;//update global responses
                    }
                    else if (data.responses.length<=this.questionNo && data.responses!=null)//first time
                    {
                        Response[] newResponses=new Response[questionNo+1];//create array with one extra response
                        count=0;
                        while(count<data.responses.length)
                        {
                            newResponses[count]=data.responses[count];//populate new array with what is in global responses
                            count++;
                        }
                        while(count<questionNo)
                        {
                            newResponses[count]=null;
                            count++;
                        }
                        count=0;
                        newResponses[questionNo]=this.response;//set the extra response
                        data.responses=newResponses;//update global responses
                    }
                    else if(data.responses.length>this.questionNo)//this question has been answered before
                    {
                        data.responses[questionNo]=this.response;
                    }
                    if(dateFlag!=1)
                    {
                        data.appScreens[prevScreen].setData(data);
                        data.appScreens[prevScreen].show();
                    }
                }
            }
            if(evt.getCommand()==next)
            {
                if(dateTime==0)//date
                {
                    //check consistency
                    String yearData=year.getSelectedItem().toString();
                    String dayData=day.getSelectedItem().toString();
                    String monthData=month.getSelectedItem().toString();
                    if(monthData.equals("September") || monthData.equals("April") || monthData.equals("June")|| monthData.equals("November")|| monthData.equals("Septemba")|| monthData.equals("Aprili") || monthData.equals("Juni") || monthData.equals("Novemba"))
                    {
                        if(dayData.equals("31"))
                        {
                            dateFlag=1;
                            //day.setSelectedIndex(29);
                            Dialog d=new Dialog("Date error");
                            d.setDialogType(Dialog.TYPE_WARNING);
                            if(language.equals("English"))
                            {
                                d.show("Inconsistent date", "Change day on the date", "ok", null);
                            }
                            else if(language.equals("Kiswahili"))
                            {
                                d.show("Tarehe mbovu", "Badilisha siku", "ok", null);
                            }
                        }
                        else
                        {
                            dateFlag=0;
                        }
                    }
                    else if(monthData.equals("February") || monthData.equals("Februari"))
                    {
                        int yr=0;
                        try
                        {
                            yr = Integer.parseInt(yearData);
                        }
                        catch(Exception e)
                        {

                        }
                        int mod=yr%4;//check if year is divisible by 4 if parseInt failed then it was either the first or last choice mod will be 0
                        if(mod==0)//leap year
                        {
                            if(dayData.equals("30") || dayData.equals("31"))
                            {
                                dateFlag=1;
                                //day.setSelectedIndex(28);//max days in 29
                                Dialog d=new Dialog("Date error");
                                d.setDialogType(Dialog.TYPE_WARNING);
                                if(language.equals("English"))
                                {
                                    d.show("Inconsistent date", "Change day on the date", "ok", null);
                                }
                                else if(language.equals("Kiswahili"))
                                {
                                    d.show("Tarehe mbovu", "Badilisha siku kwenye tarehe", "ok", null);
                                }
                            }
                            else
                            {
                                dateFlag=0;
                            }
                        }
                        else
                        {
                            if(dayData.equals("30") || dayData.equals("31") || dayData.equals("29"))
                            {
                                dateFlag=1;
                                //day.setSelectedIndex(27);//max days in 28
                                Dialog d=new Dialog("Date error");
                                d.setDialogType(Dialog.TYPE_WARNING);
                                if(language.equals("English"))
                                {
                                    d.show("Inconsistent date", "Change day on the date", "ok", null);
                                }
                                else if(language.equals("Kiswahili"))
                                {
                                    d.show("Tarehe mbovu", "Badilisha siku kwenye tarehe", "ok", null);
                                }
                            }
                            else
                            {
                                dateFlag=0;
                            }
                        }
                    }


                    String[] ans=new String[1];
                    ans[0]=day.getSelectedItem().toString()+"-"+month.getSelectedItem().toString()+"-"+year.getSelectedItem().toString();
                    this.response=new Response();
                    this.response.setQuestion(this.question.getText(), questionNo);
                    this.response.setResponses(ans);

                    //check global responses
                    int count=0;
                    if(data.responses==null)//this is the first question
                    {
                        Response[] newResponses=new Response[1];//create the array
                        newResponses[0]=new Response();
                        newResponses[0]=this.response;//add the response
                        data.responses=newResponses;//update global responses
                    }
                    else if (data.responses.length<=this.questionNo && data.responses!=null)//first time
                    {
                        Response[] newResponses=new Response[questionNo+1];//create array with one extra response
                        count=0;
                        while(count<data.responses.length)
                        {
                            newResponses[count]=data.responses[count];//populate new array with what is in global responses
                            count++;
                        }
                        while(count<questionNo)
                        {
                            newResponses[count]=null;
                            count++;
                        }
                        count=0;
                        newResponses[questionNo]=this.response;//set the extra response
                        data.responses=newResponses;//update global responses
                    }
                    else if(data.responses.length>this.questionNo)//this question has been answered before
                    {
                        data.responses[questionNo]=this.response;
                    }
                    if(dateFlag!=1)
                    {
                        data.appScreens[screenNo+1].setData(data);
                        data.appScreens[screenNo+1].setPrevScreen(this.screenNo);
                        data.appScreens[screenNo+1].show();
                    }
                }
                else if(dateTime==1)//time
                {

                    String[] ans=new String[1];
                    ans[0]=hour.getSelectedItem().toString()+":"+min.getSelectedItem().toString()+":"+sec.getSelectedItem().toString();
                    this.response=new Response();
                    this.response.setQuestion(this.question.getText(), questionNo);
                    this.response.setResponses(ans);

                    //check global responses
                    int count=0;
                    if(data.responses==null)//this is the first question
                    {
                        Response[] newResponses=new Response[1];//create the array
                        newResponses[0]=new Response();
                        newResponses[0]=this.response;//add the response
                        data.responses=newResponses;//update global responses
                    }
                    else if (data.responses.length<=this.questionNo && data.responses!=null)//first time
                    {
                        Response[] newResponses=new Response[questionNo+1];//create array with one extra response
                        count=0;
                        while(count<data.responses.length)
                        {
                            newResponses[count]=data.responses[count];//populate new array with what is in global responses
                            count++;
                        }
                        while(count<questionNo)
                        {
                            newResponses[count]=null;
                            count++;
                        }
                        count=0;
                        newResponses[questionNo]=this.response;//set the extra response
                        data.responses=newResponses;//update global responses
                    }
                    else if(data.responses.length>this.questionNo)//this question has been answered before
                    {
                        data.responses[questionNo]=this.response;
                    }

                    data.appScreens[screenNo+1].setData(data);
                    data.appScreens[screenNo+1].setPrevScreen(this.screenNo);
                    data.appScreens[screenNo+1].show();
                }
                else if(dateTime==2)//datetime
                {
                    //check consistency
                    String yearData=year.getSelectedItem().toString();
                    String dayData=day.getSelectedItem().toString();
                    String monthData=month.getSelectedItem().toString();
                    if(monthData.equals("September") || monthData.equals("April") || monthData.equals("June")|| monthData.equals("November")|| monthData.equals("Septemba")|| monthData.equals("Aprili") || monthData.equals("Juni") || monthData.equals("Novemba"))
                    {
                        if(dayData.equals("31"))
                        {
                            dateFlag=1;
                            //day.setSelectedIndex(29);
                            Dialog d=new Dialog("Date error");
                            d.setDialogType(Dialog.TYPE_WARNING);
                            if(language.equals("English"))
                            {
                                d.show("Inconsistent date", "Change day on the date", "ok", null);
                            }
                            else if(language.equals("Kiswahili"))
                            {
                                d.show("Tarehe mbovu", "Badilisha siku", "ok", null);
                            }
                        }
                        else
                        {
                            dateFlag=0;
                        }
                    }
                    else if(monthData.equals("February") || monthData.equals("Februari"))
                    {
                        int yr=0;
                        try
                        {
                            yr = Integer.parseInt(yearData);
                        }
                        catch(Exception e)
                        {

                        }
                        int mod=yr%4;//check if year is divisible by 4 if parseInt failed then it was either the first or last choice mod will be 0
                        if(mod==0)//leap year
                        {
                            if(dayData.equals("30") || dayData.equals("31"))
                            {
                                dateFlag=1;
                                //day.setSelectedIndex(28);//max days in 29
                                Dialog d=new Dialog("Date error");
                                d.setDialogType(Dialog.TYPE_WARNING);
                                if(language.equals("English"))
                                {
                                    d.show("Inconsistent date", "Change day on the date", "ok", null);
                                }
                                else if(language.equals("Kiswahili"))
                                {
                                    d.show("Tarehe mbovu", "Badilisha siku kwenye tarehe", "ok", null);
                                }
                            }
                            else
                            {
                                dateFlag=0;
                            }
                        }
                        else
                        {
                            if(dayData.equals("30") || dayData.equals("31") || dayData.equals("29"))
                            {
                                dateFlag=1;
                                //day.setSelectedIndex(27);//max days in 28
                                Dialog d=new Dialog("Date error");
                                d.setDialogType(Dialog.TYPE_WARNING);
                                if(language.equals("English"))
                                {
                                    d.show("Inconsistent date", "Change day on the date", "ok", null);
                                }
                                else if(language.equals("Kiswahili"))
                                {
                                    d.show("Tarehe mbovu", "Badilisha siku kwenye tarehe", "ok", null);
                                }
                            }
                            else
                            {
                                dateFlag=0;
                            }
                        }
                    }


                    String[] ans=new String[1];
                    ans[0]=day.getSelectedItem().toString()+"-"+month.getSelectedItem().toString()+"-"+year.getSelectedItem().toString()+" ";
                    ans[0]=ans[0]+hour.getSelectedItem().toString()+":"+min.getSelectedItem().toString()+":"+sec.getSelectedItem().toString();
                    this.response=new Response();
                    this.response.setQuestion(this.question.getText(), questionNo);
                    this.response.setResponses(ans);

                    //check global responses
                    int count=0;
                    if(data.responses==null)//this is the first question
                    {
                        Response[] newResponses=new Response[1];//create the array
                        newResponses[0]=new Response();
                        newResponses[0]=this.response;//add the response
                        data.responses=newResponses;//update global responses
                    }
                    else if (data.responses.length<=this.questionNo && data.responses!=null)//first time
                    {
                        Response[] newResponses=new Response[questionNo+1];//create array with one extra response
                        count=0;
                        while(count<data.responses.length)
                        {
                            newResponses[count]=data.responses[count];//populate new array with what is in global responses
                            count++;
                        }
                        while(count<questionNo)
                        {
                            newResponses[count]=null;
                            count++;
                        }
                        count=0;
                        newResponses[questionNo]=this.response;//set the extra response
                        data.responses=newResponses;//update global responses
                    }
                    else if(data.responses.length>this.questionNo)//this question has been answered before
                    {
                        data.responses[questionNo]=this.response;
                    }
                    if(dateFlag!=1)
                    {
                        data.appScreens[screenNo+1].setData(data);
                        data.appScreens[screenNo+1].setPrevScreen(this.screenNo);
                        data.appScreens[screenNo+1].show();
                    }
                }
            }
            //if(evt.getSource()==year || (evt.getSource()==day && dateFlag==1))
//            {
//                String yearData=year.getSelectedItem().toString();
//                String dayData=day.getSelectedItem().toString();
//                String monthData=month.getSelectedItem().toString();
//                if(monthData.equals("September") || monthData.equals("April") || monthData.equals("June")|| monthData.equals("November")|| monthData.equals("Septemba")|| monthData.equals("Aprili") || monthData.equals("Juni") || monthData.equals("Novemba"))
//                {
//                    if(dayData.equals("31"))
//                    {
//                        dateFlag=1;
//                        //day.setSelectedIndex(29);
//                        Dialog d=new Dialog("Date error");
//                        d.setDialogType(Dialog.TYPE_WARNING);
//                        if(language.equals("English"))
//                        {
//                            d.show("Inconsistent date", "Change day on the date", "ok", null);
//                        }
//                        else if(language.equals("Kiswahili"))
//                        {
//                            d.show("Tarehe mbovu", "Badilisha siku", "ok", null);
//                        }
//                    }
//                }
//                else if(monthData.equals("February") || monthData.equals("Februari"))
//                {
//                    int yr=0;
//                    try
//                    {
//                        yr = Integer.parseInt(yearData);
//                    }
//                    catch(Exception e)
//                    {
//
//                    }
//                    int mod=yr%4;//check if year is divisible by 4 if parseInt failed then it was either the first or last choice mod will be 0
//                    if(mod==0)//leap year
//                    {
//                        if(dayData.equals("30") || dayData.equals("31"))
//                        {
//                            dateFlag=1;
//                            //day.setSelectedIndex(28);//max days in 29
//                            Dialog d=new Dialog("Date error");
//                            d.setDialogType(Dialog.TYPE_WARNING);
//                            if(language.equals("English"))
//                            {
//                                d.show("Inconsistent date", "Change day on the date", "ok", null);
//                            }
//                            else if(language.equals("Kiswahili"))
//                            {
//                                d.show("Tarehe mbovu", "Badilisha siku kwenye tarehe", "ok", null);
//                            }
//                        }
//                    }
//                    else
//                    {
//                        if(dayData.equals("30") || dayData.equals("31") || dayData.equals("29"))
//                        {
//                            dateFlag=1;
//                            //day.setSelectedIndex(27);//max days in 28
//                            Dialog d=new Dialog("Date error");
//                            d.setDialogType(Dialog.TYPE_WARNING);
//                            if(language.equals("English"))
//                            {
//                                d.show("Inconsistent date", "Change day on the date", "ok", null);
//                            }
//                            else if(language.equals("Kiswahili"))
//                            {
//                                d.show("Tarehe mbovu", "Badilisha siku kwenye tarehe", "ok", null);
//                            }
//                        }
//                    }
//                }
//            }
        }
        else if (screenType.equals("footer"))
        {
            if(evt.getCommand()==previous)
            {
                data.appScreens[prevScreen].setData(data);
                data.appScreens[prevScreen].show();
            }
            else if(evt.getCommand()==next)
            {
                Midlet.xmlGenerator(data);//pass the global data to the midlet
            }
        }
    }
    private class MyCheckBox extends CheckBox implements ListCellRenderer
    {

        public MyCheckBox(String name)
        {
            super(name);
            this.getStyle().setFgColor(0x666699);
        }

        public Component getListCellRendererComponent(List list, Object value, int index, boolean isSelected)
        {
            return this;
        }

        public Component getListFocusComponent(List list)
        {
            return this;
        }

    }

    private class MyRadioButton extends RadioButton implements ListCellRenderer
    {

        public MyRadioButton(String name)
        {
            super(name);
            this.getStyle().setFgColor(0x666699);
        }

        public Component getListCellRendererComponent(List list, Object value, int index, boolean isSelected)
        {
            return this;
        }

        public Component getListFocusComponent(List list)
        {
            return this;
        }

    }

    private class MyComboBox extends ComboBox implements ListCellRenderer
    {

        public MyComboBox(String[] elements)
        {
            super(elements);
            this.getStyle().setBgColor(0x99CCCC);
        }

        public Component getListCellRendererComponent(List list, Object value, int index, boolean isSelected)
        {
            return this;
        }

        public Component getListFocusComponent(List list)
        {
            return this;
        }

    }
    private class MyListCellRenderer extends List implements ListCellRenderer
    {
        String[] name;
        public MyListCellRenderer(String[] name)
        {
            super();
            this.name=name;
        }

        public Component getListCellRendererComponent(List list, Object value, int index, boolean isSelected)
	{
            Label l=new Label(name[index]);
            if(isSelected)
            {
                l.getStyle().setBgColor(0x996666);
            }
            return l;
	}
	public Component getListFocusComponent(List list)
	{
		return this;
	}



    }
}
