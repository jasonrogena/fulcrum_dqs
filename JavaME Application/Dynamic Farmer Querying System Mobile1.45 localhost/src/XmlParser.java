

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 *
 * @author jason
 */
import java.io.IOException;
import java.io.InputStream;
import java.io.InputStreamReader;
import org.kxml2.io.KXmlParser;
import org.xmlpull.v1.XmlPullParserException;
public class XmlParser
{
    private Application application;
    private DynamicScreen[] dynamicScreens;
    private KXmlParser parser;
    public XmlParser(InputStream in)
    {
        this.parser=new KXmlParser();
        try
        {
            this.parser.setInput(new InputStreamReader(in));
        }
        catch (XmlPullParserException ex)
        {
            ex.printStackTrace();
        }
        catch (NullPointerException npx)
        {
            npx.printStackTrace();
        }
        application=null;
        dynamicScreens=null;
        
        
    }
    public Application parse() throws XmlPullParserException, IOException, NullPointerException
    {
        int eventType=KXmlParser.START_TAG;
        String name=null;
        int applicationID=0;
        String dateLastEdited=null;
        String language=null;
        String devUsername=null;
        while(eventType != KXmlParser.END_DOCUMENT)
        {
            eventType=parser.next();
            if(eventType==KXmlParser.START_TAG)
            {
                if(parser.getName().equals("name"))
                {
                    parser.next();
                    name=parser.getText();
                }
                else if(parser.getName().equals("applicationID"))
                {
                    parser.next();
                    applicationID=Integer.parseInt(parser.getText());
                }
                else if(parser.getName().equals("developerUsername"))
                {
                    parser.next();
                    devUsername=parser.getText();
                }
                else if(parser.getName().equals("lastEdited"))
                {
                    parser.next();
                    dateLastEdited=parser.getText();
                }
                else if(parser.getName().equals("language"))
                {
                    parser.next();
                    language=parser.getText();
                }
                else if(parser.getName().equals("screens"))
                {
                    int size=Integer.parseInt(parser.getAttributeValue(null,"size"));
                    dynamicScreens=new DynamicScreen[size+1];//add the finish screen
                    int count=0;
                    while(count<size)//initialize all the screens except the last
                    {
                        dynamicScreens[count]=null;
                        count++;
                    }
                    count=0;
                    int tester=parser.next();
                    while(!parser.getName().equals("screens"))
                    {
                        if(tester==KXmlParser.START_TAG && parser.getName().equals("screen"))
                        {
                            String type=parser.getAttributeValue(null, "type");
                            parseScreen(type);
                        }
                        tester=parser.next();
                        //after parseScreen is called parser is pointing at the closing tag of a screen
                    }//end of screens tag
                    //initialize the last screen
                    dynamicScreens[size]=new DynamicScreen(language);//the footer screen
                }
            }
        }
        this.application=new Application(name, applicationID, dateLastEdited, language, devUsername);
        this.application.setAppScreens(dynamicScreens);
        return this.application;
    }
    public void parseScreen(String type) throws XmlPullParserException, IOException ,NullPointerException
    {
        String screenType=null;
        int screenNo=-1;
        String heading=null;
        String introText=null;
        String language=null;
        String question=null;
        int questionNo=-1;
        int dateTime=-1;
        String text=null;
        int listSize=-1;
        int responseLength=-1;
        int wOS=-1;
        int[] nextScreens=new int[0];
        String[] choices=null;//for single,multi select and ranking
        int tester=parser.next();//now inside the screen tag but on a start tag
        while(!parser.getName().equals("screen"))//end tag for the screen
        {
            if(tester==KXmlParser.START_TAG)
            {
                if(parser.getName().equals("screenType"))
                {
                    parser.next();
                    screenType=parser.getText();
                }
                else if(parser.getName().equals("screenNo"))
                {
                    parser.next();
                    screenNo=Integer.parseInt(parser.getText());
                }
                else if(parser.getName().equals("heading"))
                {
                    parser.next();
                    heading=parser.getText();
                }
                else if(parser.getName().equals("introText"))
                {
                    parser.next();
                    introText=parser.getText();
                }
                else if(parser.getName().equals("language"))
                {
                    parser.next();
                    language=parser.getText();
                }
                else if(parser.getName().equals("question"))
                {
                    parser.next();
                    question=parser.getText();
                }
                else if(parser.getName().equals("questionNo"))
                {
                    parser.next();
                    questionNo=Integer.parseInt(parser.getText());
                }
                else if(parser.getName().equals("dateTime"))
                {
                    parser.next();
                    dateTime=Integer.parseInt(parser.getText());
                }
                else if(parser.getName().equals("text"))
                {
                    parser.next();
                    text=parser.getText();
                }
                else if(parser.getName().equals("listSize"))
                {
                    parser.next();
                    listSize=Integer.parseInt(parser.getText());
                }
                else if(parser.getName().equals("responseLength"))
                {
                    parser.next();
                    responseLength=Integer.parseInt(parser.getText());
                }
                else if(parser.getName().equals("choices"))
                {
                    if(type.equals("multiSelect") || type.equals("ranking"))
                    {
                        if(type.equals("multiSelect"))
                        {
                            wOS=Integer.parseInt(parser.getAttributeValue(null, "wOS"));
                        }
                        int choiceCount=Integer.parseInt(parser.getAttributeValue(null, "size"));
                        choices=new String[choiceCount];
                        int count=0;
                        while(count<choiceCount)
                        {
                            choices[count]=null;
                            count++;
                        }
                        count=0;
                        int choicePointer=parser.next();
                        while(!parser.getName().equals("choices"))
                        {
                            if(choicePointer==KXmlParser.START_TAG && parser.getName().equals("choice"))
                            {
                                parser.next();
                                choices[count]=parser.getText();
                                count++;
                            }
                            choicePointer=parser.next();
                        }
                        count=0;
                        
                    }
                    
                    else//if the type is single select
                    {
                        wOS=Integer.parseInt(parser.getAttributeValue(null, "wOS"));
                        int choiceCount=Integer.parseInt(parser.getAttributeValue(null, "size"));
                        choices=new String[choiceCount];
                        int count=0;
                        while(count<choiceCount)
                        {
                            choices[count]=null;
                            count++;
                        }
                        if(wOS==1)
                        {
                            nextScreens=new int[choiceCount+1];
                        }
                        else
                        {
                            nextScreens=new int[choiceCount];
                        }
                        count=0;
                        int choicePointer=parser.next();
                        while(!parser.getName().equals("choices"))
                        {
                            if(choicePointer==KXmlParser.START_TAG && parser.getName().equals("choice"))
                            {
                                nextScreens[count]=Integer.parseInt(parser.getAttributeValue(null, "nextScreen"));
                                parser.next();
                                choices[count]=parser.getText();
                                count++;
                            }
                            else if(choicePointer==KXmlParser.START_TAG && wOS==1 && parser.getName().equals("wOS"))
                            {
                                parser.next();
                                nextScreens[choiceCount]=Integer.parseInt(parser.getText());//last element in the array
                            }
                            choicePointer=parser.next();
                        }
                        count=0;
                    }
                }

            }
            tester=parser.next();
        }//screen end tag has been reached
        if(type.equals("header"))
        {
            dynamicScreens[screenNo]=new DynamicScreen(screenType, screenNo, heading, introText, language);
        }
        else if(type.equals("infoScreen"))
        {
            dynamicScreens[screenNo]=new DynamicScreen(screenType, screenNo, text, language);
        }
        else if(type.equals("list"))
        {
            dynamicScreens[screenNo]=new DynamicScreen(screenType, screenNo, question, questionNo, listSize, responseLength, language);
        }
        else if(type.equals("openEnded"))
        {
            dynamicScreens[screenNo]=new DynamicScreen(screenType, screenNo, question, questionNo, responseLength, language);
        }
        else if(type.equals("dateTime"))
        {
            dynamicScreens[screenNo]=new DynamicScreen(screenType, screenNo, question, questionNo, language, dateTime);
        }
        else if(type.equals("ranking"))
        {
            dynamicScreens[screenNo]=new DynamicScreen(screenType, screenNo, question, questionNo, choices, listSize, language);
        }
        else if(type.equals("multiSelect"))
        {
            dynamicScreens[screenNo]=new DynamicScreen(screenType, screenNo, question, questionNo, choices, language, wOS);
        }
        else if(type.equals("singleSelect"))
        {
            dynamicScreens[screenNo]=new DynamicScreen(screenType, screenNo, question, questionNo, choices, nextScreens, language, wOS);
        }
    }

}
